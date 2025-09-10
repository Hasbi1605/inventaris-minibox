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
            'nama_pelanggan' => 'required|string|max:255',
            'telepon_pelanggan' => 'nullable|string|max:20',
            'layanan_id' => 'required|exists:layanans,id',
            'tanggal_transaksi' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'total_harga' => 'required|numeric|min:0|max:999999999.99',
            'metode_pembayaran' => 'required|in:tunai,kartu_debit,kartu_kredit,transfer,ewallet',
            'status' => 'required|in:pending,sedang_proses,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:1000'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nama_pelanggan.string' => 'Nama pelanggan harus berupa teks.',
            'nama_pelanggan.max' => 'Nama pelanggan maksimal 255 karakter.',
            'telepon_pelanggan.string' => 'Telepon pelanggan harus berupa teks.',
            'telepon_pelanggan.max' => 'Telepon pelanggan maksimal 20 karakter.',
            'layanan_id.required' => 'Layanan wajib dipilih.',
            'layanan_id.exists' => 'Layanan yang dipilih tidak valid.',
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
            'tanggal_transaksi.date' => 'Tanggal transaksi harus berupa tanggal yang valid.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_mulai.date_format' => 'Format waktu mulai harus HH:MM.',
            'waktu_selesai.date_format' => 'Format waktu selesai harus HH:MM.',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
            'total_harga.required' => 'Total harga wajib diisi.',
            'total_harga.numeric' => 'Total harga harus berupa angka.',
            'total_harga.min' => 'Total harga tidak boleh kurang dari 0.',
            'total_harga.max' => 'Total harga terlalu besar.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid.',
            'status.required' => 'Status transaksi wajib dipilih.',
            'status.in' => 'Status transaksi tidak valid.',
            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan maksimal 1000 karakter.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_pelanggan' => 'nama pelanggan',
            'telepon_pelanggan' => 'telepon pelanggan',
            'layanan_id' => 'layanan',
            'tanggal_transaksi' => 'tanggal transaksi',
            'waktu_mulai' => 'waktu mulai',
            'waktu_selesai' => 'waktu selesai',
            'total_harga' => 'total harga',
            'metode_pembayaran' => 'metode pembayaran',
            'status' => 'status',
            'catatan' => 'catatan'
        ];
    }
}
