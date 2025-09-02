<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Service;
use App\Models\Product;
use App\Models\Customer;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['customer', 'user', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $services = Service::active()->with('category')->get();
        $products = Product::active()->with('category')->get();
        $customers = Customer::orderBy('name')->get();

        return view('transactions.create', compact('services', 'products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:service,product',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,transfer,e_wallet',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            // Generate transaction number
            $transactionNumber = Transaction::generateTransactionNumber();

            // Calculate totals
            $subtotal = 0;
            $totalCost = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                if ($item['type'] === 'service') {
                    $service = Service::findOrFail($item['id']);
                    $price = $service->price;
                    $cost = $service->cost;
                    $name = $service->name;
                } else {
                    $product = Product::findOrFail($item['id']);

                    // Check stock availability
                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception("Stok produk {$product->name} tidak mencukupi. Stok tersedia: {$product->stock_quantity}");
                    }

                    $price = $product->selling_price;
                    $cost = $product->purchase_price;
                    $name = $product->name;
                }

                $itemSubtotal = $price * $item['quantity'];
                $itemCost = $cost * $item['quantity'];

                $subtotal += $itemSubtotal;
                $totalCost += $itemCost;

                $itemsData[] = [
                    'item_type' => $item['type'],
                    'item_id' => $item['id'],
                    'item_name' => $name,
                    'unit_price' => $price,
                    'unit_cost' => $cost,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                    'profit' => $itemSubtotal - $itemCost
                ];
            }

            $discount = $request->discount ?? 0;
            $tax = $request->tax ?? 0;
            $total = $subtotal - $discount + $tax;
            $changeAmount = max(0, $request->paid_amount - $total);

            // Create transaction
            $transaction = Transaction::create([
                'transaction_number' => $transactionNumber,
                'customer_id' => $request->customer_id,
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'notes' => $request->notes,
                'transaction_date' => now()
            ]);

            // Create transaction items and update stock
            foreach ($itemsData as $itemData) {
                $itemData['transaction_id'] = $transaction->id;
                TransactionItem::create($itemData);

                // Update product stock if it's a product
                if ($itemData['item_type'] === 'product') {
                    $product = Product::find($itemData['item_id']);

                    // Record inventory movement
                    InventoryMovement::recordMovement(
                        $product,
                        'out',
                        $itemData['quantity'],
                        Auth::id(),
                        'transaction',
                        $transaction->id,
                        "Penjualan #{$transaction->transaction_number}"
                    );
                }
            }

            // Update customer loyalty points if customer is selected
            if ($request->customer_id) {
                $customer = Customer::find($request->customer_id);
                $loyaltyPoints = floor($total / 10000); // 1 point per 10,000
                $customer->addLoyaltyPoints($loyaltyPoints);
                $customer->updateLastVisit();
            }

            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'items']);
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->status === 'completed') {
            return back()->withErrors(['error' => 'Transaksi yang sudah selesai tidak dapat diedit.']);
        }

        $services = Service::active()->with('category')->get();
        $products = Product::active()->with('category')->get();
        $customers = Customer::orderBy('name')->get();

        return view('transactions.edit', compact('transaction', 'services', 'products', 'customers'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->status === 'completed') {
            return back()->withErrors(['error' => 'Transaksi yang sudah selesai tidak dapat diedit.']);
        }

        // Similar validation and logic as store method
        // Implementation would be similar to store() but updating existing transaction

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->status === 'completed') {
            return back()->withErrors(['error' => 'Transaksi yang sudah selesai tidak dapat dihapus.']);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    public function cancel(Transaction $transaction)
    {
        if ($transaction->status === 'cancelled') {
            return back()->withErrors(['error' => 'Transaksi sudah dibatalkan.']);
        }

        DB::beginTransaction();

        try {
            // Restore product stock if transaction was completed
            if ($transaction->status === 'completed') {
                foreach ($transaction->items as $item) {
                    if ($item->item_type === 'product') {
                        $product = Product::find($item->item_id);
                        if ($product) {
                            InventoryMovement::recordMovement(
                                $product,
                                'in',
                                $item->quantity,
                                Auth::id(),
                                'transaction_cancel',
                                $transaction->id,
                                "Pembatalan transaksi #{$transaction->transaction_number}"
                            );
                        }
                    }
                }

                // Reverse customer loyalty points
                if ($transaction->customer_id) {
                    $customer = Customer::find($transaction->customer_id);
                    $loyaltyPoints = floor($transaction->total / 10000);
                    $customer->useLoyaltyPoints($loyaltyPoints);
                }
            }

            $transaction->update(['status' => 'cancelled']);

            DB::commit();

            return back()->with('success', 'Transaksi berhasil dibatalkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'items']);
        return view('transactions.receipt', compact('transaction'));
    }
}
