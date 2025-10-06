<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CabangRequest extends FormRequest
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
        $cabang = $this->route('kelola_cabang');
        $cabangId = $cabang ? $cabang->id : null;

        return [
            'nama_cabang' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'unique:cabang,nama_cabang,' . $cabangId,
            ],
            'alamat' => [
                'required',
                'string',
                'max:500',
            ],
            'status' => [
                'required',
                'string',
                'in:aktif,tidak_aktif,maintenance,renovasi',
            ],
            'kategori_id' => [
                'required',
                'integer',
                'exists:kategoris,id',
            ],
            'jam_operasional_buka' => [
                'nullable',
                'date_format:H:i:s',
            ],
            'jam_operasional_tutup' => [
                'nullable',
                'date_format:H:i:s',
                'after:jam_operasional_buka',
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_cabang.required' => 'Nama cabang wajib diisi.',
            'nama_cabang.min' => 'Nama cabang minimal 3 karakter.',
            'nama_cabang.max' => 'Nama cabang maksimal 100 karakter.',
            'nama_cabang.unique' => 'Nama cabang sudah digunakan.',

            'alamat.required' => 'Alamat cabang wajib diisi.',
            'alamat.max' => 'Alamat cabang maksimal 500 karakter.',

            'status.required' => 'Status cabang wajib dipilih.',
            'status.in' => 'Status cabang tidak valid.',

            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.integer' => 'Kategori tidak valid.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak ditemukan.',

            'jam_operasional_buka.date_format' => 'Format jam buka tidak valid (HH:MM:SS).',
            'jam_operasional_tutup.date_format' => 'Format jam tutup tidak valid (HH:MM:SS).',
            'jam_operasional_tutup.after' => 'Jam tutup harus setelah jam buka.',

            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean and normalize status
        if ($this->has('status')) {
            $this->merge([
                'status' => strtolower(trim($this->input('status'))),
            ]);
        }

        // Clean nama_cabang
        if ($this->has('nama_cabang')) {
            $this->merge([
                'nama_cabang' => trim($this->input('nama_cabang')),
            ]);
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama_cabang' => 'nama cabang',
            'alamat' => 'alamat',
            'status' => 'status',
            'kategori_id' => 'kategori',
            'jam_operasional_buka' => 'jam operasional buka',
            'jam_operasional_tutup' => 'jam operasional tutup',
            'deskripsi' => 'deskripsi',
        ];
    }
}
