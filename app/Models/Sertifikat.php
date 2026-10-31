<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $fillable = [
        'id_prestasi',
        'file_sertifikat',
        'nama_file',
        'tgl_upload',
    ];

    protected function casts(): array
    {
        return [
            'tgl_upload' => 'date',
        ];
    }

    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(
            Prestasi::class,
            'id_prestasi'
        );
    }
}
