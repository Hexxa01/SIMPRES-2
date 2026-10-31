<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrestasiController extends Controller
{
    public function index(Request $request): View|StreamedResponse
    {
        $kategori = $request->input('kategori');
        $tingkat = $request->input('tingkat');
        $tahun = $request->input('tahun');
        $prodi = $request->input('prodi');
        $q = $request->input('q');

        $query = Prestasi::query()
            ->with(['mahasiswa', 'sertifikat', 'dokumentasi'])
            ->join('users', 'users.id', '=', 'prestasi.id_mahasiswa')
            ->select('prestasi.*')
            ->when($kategori, fn ($b) => $b->where('prestasi.jenis_prestasi', $kategori))
            ->when($tingkat, fn ($b) => $b->where('prestasi.tingkat_prestasi', $tingkat))
            ->when($tahun, fn ($b) => $b->where('prestasi.tahun_perolehan', $tahun))
            ->when($prodi, fn ($b) => $b->where('users.prodi', $prodi))
            ->when($q, function ($b) use ($q) {
                $b->where(function ($sub) use ($q) {
                    $sub->where('prestasi.nama_prestasi', 'like', "%{$q}%")
                        ->orWhere('users.nama', 'like', "%{$q}%")
                        ->orWhere('users.nim', 'like', "%{$q}%");
                });
            });

        // Export Excel
        if ($request->input('export') === 'excel') {
            $data = (clone $query)->orderByDesc('prestasi.created_at')->get();

            return response()->streamDownload(function () use ($data) {
                $out = fopen('php://output', 'w');
                fwrite($out, "\xEF\xBB\xBF");
                fputcsv($out, ['No', 'Nama Mahasiswa', 'NIM', 'Program Studi', 'Nama Prestasi', 'Kategori', 'Tingkat', 'Tahun', 'Status Verifikasi', 'Skor']);

                foreach ($data as $i => $item) {
                    fputcsv($out, [
                        $i + 1,
                        $item->mahasiswa?->nama,
                        $item->mahasiswa?->nim,
                        $item->mahasiswa?->prodi,
                        $item->nama_prestasi,
                        Prestasi::JENIS[$item->jenis_prestasi] ?? $item->jenis_prestasi,
                        Prestasi::TINGKAT[$item->tingkat_prestasi] ?? $item->tingkat_prestasi,
                        $item->tahun_perolehan,
                        Prestasi::STATUS[$item->status_verifikasi] ?? $item->status_verifikasi,
                        $item->skor ?? '-',
                    ]);
                }
                fclose($out);
            }, 'data_prestasi_mahasiswa_'.date('Ymd_His').'.csv', [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }

        $prestasi = $query->orderByDesc('prestasi.created_at')->paginate(15)->withQueryString();

        $prodiList = User::query()
            ->whereNotNull('prodi')
            ->distinct()
            ->orderBy('prodi')
            ->pluck('prodi');

        $tahunList = Prestasi::query()
            ->distinct()
            ->orderByDesc('tahun_perolehan')
            ->pluck('tahun_perolehan');

        return view('pimpinan.prestasi.index', compact(
            'prestasi',
            'kategori',
            'tingkat',
            'tahun',
            'prodi',
            'q',
            'prodiList',
            'tahunList'
        ));
    }

    public function show(Prestasi $prestasi): View
    {
        $prestasi->load(['mahasiswa', 'sertifikat', 'dokumentasi', 'verifikator']);

        return view('pimpinan.prestasi.show', compact('prestasi'));
    }
}
