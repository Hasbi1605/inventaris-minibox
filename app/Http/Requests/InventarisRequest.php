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
     * Prepare data for validation
     */
    protected function prepareForValidation()
    {
        // Check if this is operasional kategori
        $kategoriId = $this->input('kategori_id');
        $isOperasional = false;

        if ($kategoriId) {
            $kategori = \App\Models\Kategori::find($kategoriId);
            if ($kategori) {
                $isOperasional = stripos($kategori->nama_kategori, 'operasional') !== false ||
                    stripos($kategori->nama_kategori, 'aset') !== false ||
                    stripos($kategori->nama_kategori, 'peralatan') !== false;
            }
        }

        // If operasional, map jumlah_aset to stok fields and auto-set status
        if ($isOperasional && $this->has('jumlah_aset')) {
            $jumlah = $this->input('jumlah_aset', 1);
            $this->merge([
                'stok_saat_ini' => $jumlah,
                'stok_minimal' => 0,
                'harga_satuan' => $this->input('harga_satuan', 0),
                'status' => 'tersedia' // Auto-set status to 'tersedia' for operasional items
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Check if kategori is operasional based on kategori name
        $kategoriId = $this->input('kategori_id');
        $isOperasional = false;

        if ($kategoriId) {
            $kategori = \App\Models\Kategori::find($kategoriId);
            if ($kategori) {
                // Check if kategori is operasional type
                $isOperasional = stripos($kategori->nama_kategori, 'operasional') !== false ||
                    stripos($kategori->nama_kategori, 'aset') !== false ||
                    stripos($kategori->nama_kategori, 'peralatan') !== false;
            }
        }

        $rules = [
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'cabang_id' => 'required|exists:cabang,id',
            'satuan' => 'required|string|max:50',
            'status' => 'required|in:tersedia,habis,hampir_habis,discontinued'
        ];

        // Conditional rules based on kategori type
        if ($isOperasional) {
            // For operasional/aset: only need jumlah_aset
            $rules['jumlah_aset'] = 'required|integer|min:1';
            // Other fields are optional or will be auto-filled
            $rules['harga_satuan'] = 'nullable|numeric|min:0|max:999999999.99';
            $rules['stok_minimal'] = 'nullable|integer|min:0';
            $rules['stok_saat_ini'] = 'nullable|integer|min:0';
        } else {
            // For retail products: need all stok fields
            $rules['harga_satuan'] = 'required|numeric|min:0|max:999999999.99';
            $rules['stok_minimal'] = 'required|integer|min:0';
            $rules['stok_saat_ini'] = 'required|integer|min:0';
            $rules['jumlah_aset'] = 'nullable|integer|min:1';
        }

        // Add unique rule for nama_barang per cabang (combination of nama_barang + cabang_id must be unique)
        if ($this->isMethod('post')) {
            // When creating: nama_barang must be unique within the same cabang
            $rules['nama_barang'] .= '|unique:inventaris,nama_barang,NULL,id,cabang_id,' . $this->input('cabang_id');
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // When updating: nama_barang must be unique within the same cabang, except for current record
            $inventarisId = $this->route('kelola_inventari');
            $rules['nama_barang'] .= '|unique:inventaris,nama_barang,' . $inventarisId . ',id,cabang_id,' . $this->input('cabang_id');
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
            'nama_barang.unique' => 'Nama barang sudah ada di cabang ini, silakan gunakan nama lain atau pilih cabang yang berbeda.',

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
            'cabang_id.required' => 'Cabang wajib dipilih.',
            'cabang_id.exists' => 'Cabang tidak valid.',
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

            'kategori' => 'kategori',
            'cabang_id' => 'cabang',
            'stok_minimal' => 'stok minimal',
            'stok_saat_ini' => 'stok saat ini',
            'harga_satuan' => 'harga satuan',
            'satuan' => 'satuan',
            'status' => 'status'
        ];
    }
}
