<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Prestasi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $prestasiQuery = Prestasi::query()->where('id_mahasiswa', $user->id);

        $totalPrestasi = (clone $prestasiQuery)->count();
        $terverifikasi = (clone $prestasiQuery)->where('status_verifikasi', 'terverifikasi')->count();
        $dalamProses = (clone $prestasiQuery)->where('status_verifikasi', 'menunggu')->count();
        $perluPerbaikan = (clone $prestasiQuery)->where('status_verifikasi', 'perlu_perbaikan')->count();

        $riwayatPrestasi = (clone $prestasiQuery)
            ->latest()
            ->limit(5)
            ->get();

        // Diagram Batang: Jumlah Prestasi Berdasarkan Kategori (Lap. hal 104)
        $kategoriList = [
            'akademik' => 'Akademik',
            'non-akademik' => 'Non-Akademik',
            'seni_budaya' => 'Seni & Budaya',
            'olahraga' => 'Olahraga',
            'teknologi_inovasi' => 'Teknologi & Inovasi',
            'lainnya' => 'Lain-lain',
        ];

        $prestasiPerKategori = [];
        foreach ($kategoriList as $key => $label) {
            $prestasiPerKategori[$label] = (clone $prestasiQuery)->where('jenis_prestasi', $key)->count();
        }

        // Pengumuman terbaru & notifikasi
        $pengumuman = Notifikasi::query()
            ->where('id_user', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'user',
            'totalPrestasi',
            'terverifikasi',
            'dalamProses',
            'perluPerbaikan',
            'riwayatPrestasi',
            'prestasiPerKategori',
            'pengumuman'
        ));
    }
}
