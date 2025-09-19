<?php

namespace App\Http\Requests;

use App\Models\Kategori;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriStoreRequest extends FormRequest
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
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategoris', 'nama_kategori')->where(function ($query) {
                    return $query->where('jenis_kategori', $this->jenis_kategori);
                }),
            ],
            'kode_kategori' => [
                'nullable',
                'string',
                'max:10',
                'unique:kategoris,kode_kategori',
                'regex:/^[A-Z0-9]+$/'
            ],
            'deskripsi' => 'nullable|string|max:1000',
            'jenis_kategori' => [
                'required',
                Rule::in(array_keys(Kategori::getJenisKategori()))
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:kategoris,id',
                function ($attribute, $value, $fail) {
                    if ($value && $this->jenis_kategori) {
                        $parent = Kategori::find($value);
                        if ($parent && $parent->jenis_kategori !== $this->jenis_kategori) {
                            $fail('Parent kategori harus memiliki jenis yang sama.');
                        }
                    }
                }
            ],
            'urutan' => 'nullable|integer|min:0',
            'status' => 'sometimes|boolean',
            'warna' => [
                'nullable',
                'string',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'
            ],
            'ikon' => 'nullable|string|max:100'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori harus diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada dalam jenis dan parent yang sama.',
            'kode_kategori.unique' => 'Kode kategori sudah digunakan.',
            'jenis_kategori.required' => 'Jenis kategori harus dipilih.',
            'jenis_kategori.in' => 'Jenis kategori yang dipilih tidak valid.',
            'parent_id.exists' => 'Parent kategori tidak ditemukan.',
            'warna.regex' => 'Format warna harus berupa hex code (contoh: #FF0000).',
            'urutan.min' => 'Urutan tidak boleh kurang dari 0.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama_kategori' => 'nama kategori',
            'kode_kategori' => 'kode kategori',
            'deskripsi' => 'deskripsi',
            'jenis_kategori' => 'jenis kategori',
            'parent_id' => 'parent kategori',
            'urutan' => 'urutan',
            'status' => 'status',
            'warna' => 'warna',
            'ikon' => 'ikon'
        ];
    }
}
