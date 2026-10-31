<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';

    public const JENIS = [
        'akademik' => 'Akademik',
        'non-akademik' => 'Non-Akademik',
        'seni_budaya' => 'Seni dan Budaya',
        'olahraga' => 'Olahraga',
        'teknologi_inovasi' => 'Teknologi dan Inovasi',
        'lainnya' => 'Lain-lain',
    ];

    public const TINGKAT = [
        'lokal' => 'Lokal / Perguruan Tinggi',
        'daerah' => 'Daerah / Provinsi',
        'nasional' => 'Nasional',
        'internasional' => 'Internasional',
    ];

    public const PEROLEHAN = [
        'juara_1' => 'Juara 1',
        'juara_2' => 'Juara 2',
        'juara_3' => 'Juara 3',
        'harapan' => 'Juara Harapan',
        'finalis' => 'Finalis',
        'partisipasi' => 'Partisipasi',
        'lainnya' => 'Peringkat Lainnya',
    ];

    public const STATUS = [
        'menunggu' => 'Menunggu Verifikasi',
        'terverifikasi' => 'Terverifikasi',
        'ditolak' => 'Ditolak',
        'perlu_perbaikan' => 'Perlu Perbaikan',
    ];

    public const STATUS_BADGE = [
        'menunggu' => 'warning',
        'terverifikasi' => 'success',
        'ditolak' => 'danger',
        'perlu_perbaikan' => 'info',
    ];

    protected $fillable = [
        'id_mahasiswa',
        'nama_prestasi',
        'jenis_prestasi',
        'tingkat_prestasi',
        'perolehan',
        'tahun_perolehan',
        'tahun_penyelenggaraan',
        'penyelenggara',
        'tempat_pelaksanaan',
        'deskripsi',
        'status_verifikasi',
        'skor',
        'catatan_revisi',
        'id_admin',
        'diverifikasi_pada',
    ];

    protected function casts(): array
    {
        return [
            'tahun_perolehan' => 'integer',
            'tahun_penyelenggaraan' => 'integer',
            'skor' => 'decimal:2',
            'diverifikasi_pada' => 'datetime',
        ];
    }

    /* ---------------- Relasi ---------------- */

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_mahasiswa');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_mahasiswa');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function sertifikat(): HasMany
    {
        return $this->hasMany(Sertifikat::class, 'id_prestasi');
    }

    public function dokumentasi(): HasMany
    {
        return $this->hasMany(Dokumentasi::class, 'id_prestasi');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_prestasi');
    }

    /* ---------------- Label tampilan ---------------- */

    public function jenisLabel(): string
    {
        return self::JENIS[$this->jenis_prestasi] ?? '-';
    }

    public function tingkatLabel(): string
    {
        return self::TINGKAT[$this->tingkat_prestasi] ?? '-';
    }

    public function perolehanLabel(): string
    {
        return self::PEROLEHAN[$this->perolehan] ?? '-';
    }

    public function statusLabel(): string
    {
        return self::STATUS[$this->status_verifikasi] ?? '-';
    }

    public function statusBadge(): string
    {
        return self::STATUS_BADGE[$this->status_verifikasi] ?? 'secondary';
    }

    public function skorTampil(): string
    {
        return $this->skor === null
            ? '-'
            : number_format((float) $this->skor, 2, ',', '.');
    }

    /* ---------------- Scope pencarian & filter ---------------- */

    /**
     * Filter berdasarkan kolom prestasi: status, kategori, tingkat,
     * perolehan, tahun, dan rentang skor.
     */
    public function scopeFilterData(Builder $query, array $f): Builder
    {
        foreach ([
            'status_verifikasi',
            'jenis_prestasi',
            'tingkat_prestasi',
            'perolehan',
            'tahun_perolehan',
        ] as $kolom) {
            if (isset($f[$kolom]) && $f[$kolom] !== '') {
                $query->where('prestasi.'.$kolom, $f[$kolom]);
            }
        }

        if (isset($f['skor_min']) && $f['skor_min'] !== '') {
            $query->where('prestasi.skor', '>=', $f['skor_min']);
        }

        if (isset($f['skor_max']) && $f['skor_max'] !== '') {
            $query->where('prestasi.skor', '<=', $f['skor_max']);
        }

        return $query;
    }

    /**
     * Pencarian kata kunci (nama prestasi, penyelenggara, nama mahasiswa,
     * NIM) dan filter program studi mahasiswa.
     */
    public function scopeCari(
        Builder $query,
        ?string $kataKunci,
        ?string $prodi = null
    ): Builder {
        if ($prodi) {
            $query->whereHas('mahasiswa', function ($m) use ($prodi) {
                $m->where('prodi', $prodi);
            });
        }

        if ($kataKunci) {
            $like = '%'.addcslashes($kataKunci, '\\%_').'%';

            $query->where(function ($b) use ($like) {
                $b->where('prestasi.nama_prestasi', 'like', $like)
                    ->orWhere('prestasi.penyelenggara', 'like', $like)
                    ->orWhereHas('mahasiswa', function ($m) use ($like) {
                        $m->where(function ($x) use ($like) {
                            $x->where('nama', 'like', $like)
                                ->orWhere('nim', 'like', $like);
                        });
                    });
            });
        }

        return $query;
    }
}
