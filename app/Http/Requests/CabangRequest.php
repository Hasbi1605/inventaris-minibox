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
        $cabangId = $this->route('kelola_cabang') ?? null;

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
                'min:10',
                'max:500',
            ],
            'telepon' => [
                'required',
                'string',
                'min:10',
                'max:15',
                'regex:/^[0-9+\-\s()]+$/',
                'unique:cabang,telepon,' . $cabangId,
            ],
            'email' => [
                'nullable',
                'email',
                'max:100',
                'unique:cabang,email,' . $cabangId,
            ],
            'manager' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'status' => [
                'required',
                'string',
                'in:aktif,tidak_aktif,maintenance,renovasi',
            ],
            'tanggal_buka' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'jam_operasional_buka' => [
                'nullable',
                'date_format:H:i',
            ],
            'jam_operasional_tutup' => [
                'nullable',
                'date_format:H:i',
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
            'alamat.min' => 'Alamat cabang minimal 10 karakter.',
            'alamat.max' => 'Alamat cabang maksimal 500 karakter.',

            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.min' => 'Nomor telepon minimal 10 karakter.',
            'telepon.max' => 'Nomor telepon maksimal 15 karakter.',
            'telepon.regex' => 'Format nomor telepon tidak valid.',
            'telepon.unique' => 'Nomor telepon sudah digunakan.',

            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'manager.required' => 'Nama manager wajib diisi.',
            'manager.min' => 'Nama manager minimal 3 karakter.',
            'manager.max' => 'Nama manager maksimal 100 karakter.',

            'status.required' => 'Status cabang wajib dipilih.',
            'status.in' => 'Status cabang tidak valid.',

            'tanggal_buka.required' => 'Tanggal buka wajib diisi.',
            'tanggal_buka.date' => 'Tanggal buka tidak valid.',
            'tanggal_buka.before_or_equal' => 'Tanggal buka tidak boleh lebih dari hari ini.',

            'jam_operasional_buka.date_format' => 'Format jam buka tidak valid (HH:MM).',
            'jam_operasional_tutup.date_format' => 'Format jam tutup tidak valid (HH:MM).',
            'jam_operasional_tutup.after' => 'Jam tutup harus setelah jam buka.',

            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean phone number
        if ($this->has('telepon')) {
            $telepon = $this->input('telepon');
            // Remove extra spaces and normalize format
            $cleanTelepon = preg_replace('/\s+/', ' ', trim($telepon));
            $this->merge([
                'telepon' => $cleanTelepon,
            ]);
        }

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

        // Clean manager name
        if ($this->has('manager')) {
            $this->merge([
                'manager' => trim($this->input('manager')),
            ]);
        }

        // Clean email
        if ($this->has('email') && !empty($this->input('email'))) {
            $this->merge([
                'email' => strtolower(trim($this->input('email'))),
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
            'telepon' => 'nomor telepon',
            'email' => 'email',
            'manager' => 'manager',
            'status' => 'status',
            'tanggal_buka' => 'tanggal buka',
            'jam_operasional_buka' => 'jam operasional buka',
            'jam_operasional_tutup' => 'jam operasional tutup',
            'deskripsi' => 'deskripsi',
        ];
    }
}
