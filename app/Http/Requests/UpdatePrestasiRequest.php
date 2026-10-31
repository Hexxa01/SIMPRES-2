<?php

namespace App\Http\Requests;

use App\Models\Prestasi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePrestasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        $prestasi = $this->route('prestasi');

        return $this->user()?->isMahasiswa()
            && $prestasi
            && $this->user()->can('update', $prestasi);
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

            // Kosongkan bila sertifikat lama tetap dipakai - format PDF, DOC, DOCX, JPG, PNG
            'sertifikat' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],

            // Dokumentasi baru ditambahkan; yang lama bisa dipilih untuk dihapus
            'dokumentasi' => ['nullable', 'array', 'max:10'],
            'dokumentasi.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'keterangan_dokumentasi' => ['nullable', 'array'],
            'keterangan_dokumentasi.*' => ['nullable', 'string', 'max:1000'],
            'hapus_dokumentasi' => ['nullable', 'array'],
            'hapus_dokumentasi.*' => ['integer'],
        ];
    }
}
