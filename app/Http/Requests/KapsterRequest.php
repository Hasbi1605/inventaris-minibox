<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KapsterRequest extends FormRequest
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
        $kapsterId = $this->route('kelola_kapster') ?? null;

        return [
            'nama_kapster' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'cabang_id' => [
                'required',
                'integer',
                'exists:cabang,id',
            ],
            'spesialisasi' => [
                'nullable',
                'string',
                'max:255',
            ],
            'status' => [
                'required',
                'string',
                'in:aktif,tidak_aktif',
            ],
            'telepon' => [
                'nullable',
                'string',
                'min:10',
                'max:15',
                'regex:/^[0-9+\-\s()]+$/',
            ],
            'komisi_potong_rambut' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'komisi_layanan_lain' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'komisi_produk' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
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
            'nama_kapster.required' => 'Nama kapster wajib diisi.',
            'nama_kapster.min' => 'Nama kapster minimal 3 karakter.',
            'nama_kapster.max' => 'Nama kapster maksimal 100 karakter.',

            'cabang_id.required' => 'Cabang wajib dipilih.',
            'cabang_id.integer' => 'Cabang tidak valid.',
            'cabang_id.exists' => 'Cabang yang dipilih tidak ditemukan.',

            'spesialisasi.max' => 'Spesialisasi maksimal 255 karakter.',

            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',

            'telepon.min' => 'Nomor telepon minimal 10 karakter.',
            'telepon.max' => 'Nomor telepon maksimal 15 karakter.',
            'telepon.regex' => 'Format nomor telepon tidak valid.',

            'komisi_potong_rambut.required' => 'Komisi potong rambut wajib diisi.',
            'komisi_potong_rambut.numeric' => 'Komisi potong rambut harus berupa angka.',
            'komisi_potong_rambut.min' => 'Komisi potong rambut minimal 0%.',
            'komisi_potong_rambut.max' => 'Komisi potong rambut maksimal 100%.',

            'komisi_layanan_lain.required' => 'Komisi layanan lain wajib diisi.',
            'komisi_layanan_lain.numeric' => 'Komisi layanan lain harus berupa angka.',
            'komisi_layanan_lain.min' => 'Komisi layanan lain minimal 0%.',
            'komisi_layanan_lain.max' => 'Komisi layanan lain maksimal 100%.',

            'komisi_produk.required' => 'Komisi produk wajib diisi.',
            'komisi_produk.numeric' => 'Komisi produk harus berupa angka.',
            'komisi_produk.min' => 'Komisi produk minimal 0%.',
            'komisi_produk.max' => 'Komisi produk maksimal 100%.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean nama_kapster
        if ($this->has('nama_kapster')) {
            $this->merge([
                'nama_kapster' => trim($this->input('nama_kapster')),
            ]);
        }

        // Clean telepon
        if ($this->has('telepon') && !empty($this->input('telepon'))) {
            $telepon = $this->input('telepon');
            $cleanTelepon = preg_replace('/\s+/', ' ', trim($telepon));
            $this->merge([
                'telepon' => $cleanTelepon,
            ]);
        }

        // Clean status
        if ($this->has('status')) {
            $this->merge([
                'status' => strtolower(trim($this->input('status'))),
            ]);
        }

        // Clean spesialisasi
        if ($this->has('spesialisasi') && !empty($this->input('spesialisasi'))) {
            $this->merge([
                'spesialisasi' => trim($this->input('spesialisasi')),
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
            'nama_kapster' => 'nama kapster',
            'cabang_id' => 'cabang',
            'spesialisasi' => 'spesialisasi',
            'status' => 'status',
            'telepon' => 'nomor telepon',
            'komisi_potong_rambut' => 'komisi potong rambut',
            'komisi_layanan_lain' => 'komisi layanan lain',
            'komisi_produk' => 'komisi produk',
        ];
    }
}
