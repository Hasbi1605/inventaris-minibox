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
        $rules = [
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'harga' => 'required|numeric|min:0|max:999999999.99',
            'durasi_estimasi' => 'required|integer|min:1|max:480', // max 8 jam
            'kategori' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif'
        ];

        // Add unique rule for nama_layanan when creating or updating different record
        if ($this->isMethod('post')) {
            $rules['nama_layanan'] .= '|unique:layanans,nama_layanan';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $layananId = $this->route('layanan') ?? $this->route('id');
            $rules['nama_layanan'] .= '|unique:layanans,nama_layanan,' . $layananId;
        }

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
            'harga.required' => 'Harga layanan wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'harga.max' => 'Harga terlalu besar.',
            'durasi_estimasi.required' => 'Durasi estimasi wajib diisi.',
            'durasi_estimasi.integer' => 'Durasi estimasi harus berupa angka bulat.',
            'durasi_estimasi.min' => 'Durasi estimasi minimal 1 menit.',
            'durasi_estimasi.max' => 'Durasi estimasi maksimal 480 menit (8 jam).',
            'kategori.string' => 'Kategori harus berupa teks.',
            'kategori.max' => 'Kategori maksimal 100 karakter.',
            'status.required' => 'Status layanan wajib dipilih.',
            'status.in' => 'Status layanan harus aktif atau nonaktif.'
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
            'harga' => 'harga',
            'durasi_estimasi' => 'durasi estimasi',
            'kategori' => 'kategori',
            'status' => 'status'
        ];
    }
}
