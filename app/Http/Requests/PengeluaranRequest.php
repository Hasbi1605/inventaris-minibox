<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengeluaranRequest extends FormRequest
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
            'deskripsi' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'kategori' => [
                'required',
                'string',
                'in:operasional,inventaris,promosi,maintenance,gaji,utilitas,lainnya',
            ],
            'jumlah' => [
                'required',
                'numeric',
                'min:1',
                'max:999999999',
            ],
            'tanggal_pengeluaran' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'catatan' => [
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
            'deskripsi.required' => 'Deskripsi pengeluaran wajib diisi.',
            'deskripsi.min' => 'Deskripsi pengeluaran minimal 3 karakter.',
            'deskripsi.max' => 'Deskripsi pengeluaran maksimal 255 karakter.',

            'kategori.required' => 'Kategori pengeluaran wajib dipilih.',
            'kategori.in' => 'Kategori pengeluaran tidak valid.',

            'jumlah.required' => 'Jumlah pengeluaran wajib diisi.',
            'jumlah.numeric' => 'Jumlah pengeluaran harus berupa angka.',
            'jumlah.min' => 'Jumlah pengeluaran minimal Rp 1.',
            'jumlah.max' => 'Jumlah pengeluaran terlalu besar.',

            'tanggal_pengeluaran.required' => 'Tanggal pengeluaran wajib diisi.',
            'tanggal_pengeluaran.date' => 'Tanggal pengeluaran tidak valid.',
            'tanggal_pengeluaran.before_or_equal' => 'Tanggal pengeluaran tidak boleh lebih dari hari ini.',

            'catatan.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Remove currency formatting from jumlah
        if ($this->has('jumlah')) {
            $jumlah = $this->input('jumlah');
            // Remove Rp, dots, commas, and spaces
            $cleanJumlah = preg_replace('/[^\d]/', '', $jumlah);
            $this->merge([
                'jumlah' => $cleanJumlah ?: 0,
            ]);
        }

        // Clean kategori
        if ($this->has('kategori')) {
            $this->merge([
                'kategori' => strtolower(trim($this->input('kategori'))),
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
            'deskripsi' => 'deskripsi pengeluaran',
            'kategori' => 'kategori pengeluaran',
            'jumlah' => 'jumlah pengeluaran',
            'tanggal_pengeluaran' => 'tanggal pengeluaran',
            'catatan' => 'catatan',
        ];
    }
}
