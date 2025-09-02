<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->when(request('category'), function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when(request('low_stock'), function ($query) {
                $query->lowStock();
            })
            ->orderBy('name')
            ->paginate(20);

        $categories = Category::forProducts()->active()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::forProducts()->active()->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku',
            'barcode' => 'nullable|string|unique:products,barcode',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        $product = Product::create($request->all());

        // Record initial stock if any
        if ($product->stock_quantity > 0) {
            InventoryMovement::recordMovement(
                $product,
                'in',
                $product->stock_quantity,
                Auth::id(),
                'initial_stock',
                null,
                'Stok awal produk'
            );
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'inventoryMovements.user']);

        $movements = $product->inventoryMovements()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('products.show', compact('product', 'movements'));
    }

    public function edit(Product $product)
    {
        $categories = Category::forProducts()->active()->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|unique:products,barcode,' . $product->id,
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        $product->update($request->except('stock_quantity'));

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->transactionItems()->exists()) {
            return back()->withErrors(['error' => 'Produk tidak dapat dihapus karena sudah pernah digunakan dalam transaksi.']);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function adjustStock(Request $request, Product $product)
    {
        $request->validate([
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $oldStock = $product->stock_quantity;
        $quantity = $request->quantity;

        switch ($request->adjustment_type) {
            case 'add':
                $newStock = $oldStock + $quantity;
                $movementType = 'in';
                $movementQuantity = $quantity;
                break;
            case 'subtract':
                $newStock = max(0, $oldStock - $quantity);
                $movementType = 'out';
                $movementQuantity = min($quantity, $oldStock);
                break;
            case 'set':
                $newStock = $quantity;
                $movementType = $quantity > $oldStock ? 'in' : 'out';
                $movementQuantity = abs($quantity - $oldStock);
                break;
        }

        // Update stock
        $product->update(['stock_quantity' => $newStock]);

        // Record movement
        if ($movementQuantity > 0) {
            InventoryMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => 'adjustment',
                'quantity' => $movementType === 'in' ? $movementQuantity : -$movementQuantity,
                'stock_before' => $oldStock,
                'stock_after' => $newStock,
                'reference_type' => 'manual_adjustment',
                'notes' => $request->notes ?? 'Penyesuaian stok manual',
                'movement_date' => now()
            ]);
        }

        return back()->with('success', 'Stok berhasil disesuaikan!');
    }

    public function lowStock()
    {
        $products = Product::lowStock()->active()->with('category')->get();
        return view('products.low-stock', compact('products'));
    }

    public function barcode(Product $product)
    {
        return view('products.barcode', compact('product'));
    }
}
