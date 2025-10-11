<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LayananRequest extends FormRequest
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
        $layananId = $this->route('kelola_layanan');

        $rules = [
            'nama_layanan' => [
                'required',
                'string',
                'max:255',
                $this->isMethod('post')
                    ? 'unique:layanans,nama_layanan'
                    : 'unique:layanans,nama_layanan,' . $layananId
            ],
            'deskripsi' => 'nullable|string|max:1000',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'status' => 'required|in:aktif,tidak_aktif',
            'cabang_ids' => 'required|array|min:1',
            'cabang_ids.*' => 'required|exists:cabang,id',
            'harga_cabang' => 'required|array|min:1',
            'harga_cabang.*' => 'required|numeric|min:0|max:999999999.99'
        ];

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_layanan.required' => 'Nama layanan wajib diisi.',
            'nama_layanan.string' => 'Nama layanan harus berupa teks.',
            'nama_layanan.max' => 'Nama layanan maksimal 255 karakter.',
            'nama_layanan.unique' => 'Nama layanan sudah ada, silakan gunakan nama lain.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'status.required' => 'Status layanan wajib dipilih.',
            'status.in' => 'Status layanan harus aktif atau tidak_aktif.',
            'cabang_ids.required' => 'Minimal pilih 1 cabang.',
            'cabang_ids.array' => 'Format cabang tidak valid.',
            'cabang_ids.min' => 'Minimal pilih 1 cabang.',
            'cabang_ids.*.exists' => 'Cabang yang dipilih tidak valid.',
            'harga_cabang.required' => 'Harga untuk setiap cabang wajib diisi.',
            'harga_cabang.array' => 'Format harga cabang tidak valid.',
            'harga_cabang.min' => 'Minimal isi harga untuk 1 cabang.',
            'harga_cabang.*.required' => 'Harga cabang wajib diisi.',
            'harga_cabang.*.numeric' => 'Harga cabang harus berupa angka.',
            'harga_cabang.*.min' => 'Harga cabang tidak boleh kurang dari 0.',
            'harga_cabang.*.max' => 'Harga cabang terlalu besar.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_layanan' => 'nama layanan',
            'deskripsi' => 'deskripsi',
            'kategori_id' => 'kategori',
            'status' => 'status',
            'cabang_ids' => 'cabang',
            'harga_cabang' => 'harga cabang'
        ];
    }
}
