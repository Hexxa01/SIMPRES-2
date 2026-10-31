<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifikasiPrestasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'status_verifikasi' => [
                'required',
                Rule::in([
                    'terverifikasi',
                    'ditolak',
                    'perlu_perbaikan',
                ]),
            ],
            'skor' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
                'required_if:status_verifikasi,terverifikasi',
            ],
            'catatan_revisi' => [
                'nullable',
                'string',
                'max:5000',
                'required_if:status_verifikasi,ditolak',
                'required_if:status_verifikasi,perlu_perbaikan',
            ],
        ];
    }
}
