<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use App\Models\Prestasi;
use App\Models\Sertifikat;
use App\Services\BerkasPrestasiService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Menyajikan sertifikat & dokumentasi dari disk privat.
 * Hanya pemilik prestasi atau Admin yang boleh membuka (PrestasiPolicy@view).
 */
class BerkasController extends Controller
{
    public function sertifikat(Sertifikat $sertifikat): StreamedResponse
    {
        return $this->kirim(
            $sertifikat->prestasi,
            $sertifikat->file_sertifikat,
            $sertifikat->nama_file
        );
    }

    public function dokumentasi(Dokumentasi $dokumentasi): StreamedResponse
    {
        return $this->kirim(
            $dokumentasi->prestasi,
            $dokumentasi->file_dokumentasi,
            $dokumentasi->nama_file
        );
    }

    private function kirim(Prestasi $prestasi, string $path, string $nama): StreamedResponse
    {
        Gate::authorize('view', $prestasi);

        $disk = Storage::disk(BerkasPrestasiService::DISK);

        abort_unless($disk->exists($path), 404, 'Berkas tidak ditemukan.');

        return $disk->response($path, $nama, [
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
