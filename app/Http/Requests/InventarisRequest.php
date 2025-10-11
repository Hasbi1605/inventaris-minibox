<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

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
        Log::info('===== InventarisRequest prepareForValidation START =====', [
            'method' => $this->method(),
            'route_id' => $this->route('kelola_inventari'),
            'all_input' => $this->all()
        ]);

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

        Log::info('Kategori check', [
            'kategori_id' => $kategoriId,
            'is_operasional' => $isOperasional
        ]);

        // If operasional, map jumlah_aset to stok fields and auto-set status
        if ($isOperasional && $this->has('jumlah_aset')) {
            $jumlah = $this->input('jumlah_aset', 1);
            $this->merge([
                'stok_saat_ini' => $jumlah,
                'stok_minimal' => 0,
                'harga_satuan' => $this->input('harga_satuan', 0),
                'status' => 'tersedia' // Auto-set status to 'tersedia' for operasional items
            ]);
            Log::info('Operasional item - merged fields', [
                'stok_saat_ini' => $jumlah,
                'status' => 'tersedia'
            ]);
        } else {
            // For retail products, auto-determine status based on stock unless manually set to discontinued
            // This is CRITICAL to fix the issue when stock is 0 and being increased
            $currentStatus = $this->input('status');

            Log::info('Retail product - determining status', [
                'current_status' => $currentStatus,
                'stok_saat_ini' => $this->input('stok_saat_ini'),
                'stok_minimal' => $this->input('stok_minimal')
            ]);

            // If status is not manually set to 'discontinued', auto-determine it
            if ($currentStatus !== 'discontinued') {
                $stokSaatIni = (int) $this->input('stok_saat_ini', 0);
                $stokMinimal = (int) $this->input('stok_minimal', 0);

                // Auto-determine status based on stock levels
                if ($stokSaatIni <= 0) {
                    $this->merge(['status' => 'habis']);
                    Log::info('Status set to: habis');
                } elseif ($stokSaatIni <= $stokMinimal) {
                    $this->merge(['status' => 'hampir_habis']);
                    Log::info('Status set to: hampir_habis');
                } else {
                    $this->merge(['status' => 'tersedia']);
                    Log::info('Status set to: tersedia');
                }
            }
        }

        Log::info('===== InventarisRequest prepareForValidation END =====');
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
            'status' => 'nullable|in:tersedia,habis,hampir_habis,discontinued' // Made nullable since it will be auto-determined
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

        // Build the unique rule for nama_barang scoped to the cabang_id
        $uniqueRule = Rule::unique('inventaris', 'nama_barang')
            ->where(function ($query) {
                return $query->where('cabang_id', $this->input('cabang_id'));
            });

        // If updating, ignore the current inventaris ID
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Get ID from route parameter - Laravel resource uses singular form without 's'
            $inventarisId = $this->route('kelola_inventari');

            // CRITICAL FIX: Pastikan ID valid sebelum ignore
            if ($inventarisId) {
                $uniqueRule->ignore($inventarisId, 'id');
                Log::info('Ignoring current record in unique validation', [
                    'inventaris_id' => $inventarisId,
                    'nama_barang' => $this->input('nama_barang'),
                    'cabang_id' => $this->input('cabang_id')
                ]);
            }
        }

        // Assign the complete rule set for nama_barang
        $rules['nama_barang'] = [
            'required',
            'string',
            'max:255',
            $uniqueRule,
        ];

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
