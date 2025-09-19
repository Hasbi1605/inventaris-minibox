<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventarisRequest extends FormRequest
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
        $rules = [
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok_minimal' => 'required|integer|min:0',
            'stok_saat_ini' => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0|max:999999999.99',
            'satuan' => 'required|string|max:50',
            'merek' => 'nullable|string|max:100',
            'tanggal_kadaluarsa' => 'nullable|date|after:today',
            'status' => 'nullable|in:tersedia,habis,hampir_habis,kadaluarsa'
        ];

        // Add unique rule for nama_barang when creating or updating different record
        if ($this->isMethod('post')) {
            $rules['nama_barang'] .= '|unique:inventaris,nama_barang';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $inventarisId = $this->route('kelola_inventari');
            $rules['nama_barang'] .= '|unique:inventaris,nama_barang,' . $inventarisId;
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.string' => 'Nama barang harus berupa teks.',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter.',
            'nama_barang.unique' => 'Nama barang sudah ada, silakan gunakan nama lain.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori tidak valid.',
            'stok_minimal.required' => 'Stok minimal wajib diisi.',
            'stok_minimal.integer' => 'Stok minimal harus berupa angka bulat.',
            'stok_minimal.min' => 'Stok minimal tidak boleh kurang dari 0.',
            'stok_saat_ini.required' => 'Stok saat ini wajib diisi.',
            'stok_saat_ini.integer' => 'Stok saat ini harus berupa angka bulat.',
            'stok_saat_ini.min' => 'Stok saat ini tidak boleh kurang dari 0.',
            'harga_satuan.required' => 'Harga satuan wajib diisi.',
            'harga_satuan.numeric' => 'Harga satuan harus berupa angka.',
            'harga_satuan.min' => 'Harga satuan tidak boleh kurang dari 0.',
            'harga_satuan.max' => 'Harga satuan terlalu besar.',
            'satuan.required' => 'Satuan wajib diisi.',
            'satuan.string' => 'Satuan harus berupa teks.',
            'satuan.max' => 'Satuan maksimal 50 karakter.',
            'merek.string' => 'Merek harus berupa teks.',
            'merek.max' => 'Merek maksimal 100 karakter.',
            'tanggal_kadaluarsa.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid.',
            'tanggal_kadaluarsa.after' => 'Tanggal kadaluarsa harus setelah hari ini.',
            'status.in' => 'Status tidak valid.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_barang' => 'nama barang',
            'deskripsi' => 'deskripsi',
            'kategori' => 'kategori',
            'stok_minimal' => 'stok minimal',
            'stok_saat_ini' => 'stok saat ini',
            'harga_satuan' => 'harga satuan',
            'satuan' => 'satuan',
            'merek' => 'merek',
            'tanggal_kadaluarsa' => 'tanggal kadaluarsa',
            'status' => 'status'
        ];
    }
}
