<?php

namespace App\Http\Requests;

use App\Models\Prestasi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePrestasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isMahasiswa() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_prestasi' => ['required', 'string', 'max:200'],
            'jenis_prestasi' => ['required', Rule::in(array_keys(Prestasi::JENIS))],
            'tingkat_prestasi' => ['required', Rule::in(array_keys(Prestasi::TINGKAT))],
            'perolehan' => ['required', Rule::in(array_keys(Prestasi::PEROLEHAN))],
            'tahun_perolehan' => ['required', 'integer', 'min:1900', 'max:'.now()->year],
            'tahun_penyelenggaraan' => ['nullable', 'integer', 'min:1900', 'max:'.(now()->year + 1)],
            'penyelenggara' => ['required', 'string', 'max:200'],
            'tempat_pelaksanaan' => ['nullable', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string', 'max:3000'],

            // Sertifikat/bukti wajib (F-05) - Mendukung PDF, DOC, DOCX, JPG, PNG (Lap. hal 108)
            'sertifikat' => ['required', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],

            // Dokumentasi bersifat opsional ("jika tersedia", activity 2.2 / ERD 0..*)
            'dokumentasi' => ['nullable', 'array', 'max:10'],
            'dokumentasi.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'keterangan_dokumentasi' => ['nullable', 'array'],
            'keterangan_dokumentasi.*' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
