<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cabang_id' => 'required|exists:cabang,id',
            'layanan_id' => 'required|exists:layanans,id',
            'kapster_id' => 'required|exists:kapster,id',
            'tanggal_transaksi' => 'required|date',
            'total_harga' => 'required|numeric|min:0|max:999999999.99',
            'metode_pembayaran' => 'required|in:tunai,transfer,qris',
            'status' => 'required|in:pending,sedang_proses,selesai,dibatalkan',
            'quantity_transaksi' => 'required|integer|min:1|max:50',
            'catatan' => 'nullable|string|max:1000',
            'produk' => 'nullable|array',
            'produk.*.inventaris_id' => 'required_with:produk|exists:inventaris,id',
            'produk.*.quantity' => 'required_with:produk|integer|min:1'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cabang_id.required' => 'Cabang wajib dipilih.',
            'cabang_id.exists' => 'Cabang yang dipilih tidak valid.',
            'layanan_id.required' => 'Layanan wajib dipilih.',
            'layanan_id.exists' => 'Layanan yang dipilih tidak valid.',
            'kapster_id.required' => 'Kapster wajib dipilih.',
            'kapster_id.exists' => 'Kapster yang dipilih tidak valid.',
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
            'tanggal_transaksi.date' => 'Tanggal transaksi harus berupa tanggal yang valid.',
            'total_harga.required' => 'Total harga wajib diisi.',
            'total_harga.numeric' => 'Total harga harus berupa angka.',
            'total_harga.min' => 'Total harga tidak boleh kurang dari 0.',
            'total_harga.max' => 'Total harga terlalu besar.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid.',
            'status.required' => 'Status transaksi wajib dipilih.',
            'status.in' => 'Status transaksi tidak valid.',
            'quantity_transaksi.required' => 'Jumlah transaksi wajib diisi.',
            'quantity_transaksi.integer' => 'Jumlah transaksi harus berupa angka.',
            'quantity_transaksi.min' => 'Jumlah transaksi minimal 1.',
            'quantity_transaksi.max' => 'Jumlah transaksi maksimal 50.',
            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan maksimal 1000 karakter.',
            'produk.array' => 'Data produk tidak valid.',
            'produk.*.inventaris_id.required_with' => 'Produk wajib dipilih.',
            'produk.*.inventaris_id.exists' => 'Produk yang dipilih tidak valid.',
            'produk.*.quantity.required_with' => 'Jumlah produk wajib diisi.',
            'produk.*.quantity.integer' => 'Jumlah produk harus berupa angka.',
            'produk.*.quantity.min' => 'Jumlah produk minimal 1.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'cabang_id' => 'cabang',
            'layanan_id' => 'layanan',
            'kapster_id' => 'kapster',
            'tanggal_transaksi' => 'tanggal transaksi',
            'total_harga' => 'total harga',
            'metode_pembayaran' => 'metode pembayaran',
            'status' => 'status',
            'quantity_transaksi' => 'jumlah transaksi',
            'catatan' => 'catatan',
            'produk.*.inventaris_id' => 'produk',
            'produk.*.quantity' => 'jumlah produk'
        ];
    }
}
