<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePrestasiRequest;
use App\Http\Requests\UpdatePrestasiRequest;
use App\Models\Notifikasi;
use App\Models\Prestasi;
use App\Services\BerkasPrestasiService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PrestasiController extends Controller
{
    private const MAKS_DOKUMENTASI = 10;

    public function __construct(private BerkasPrestasiService $berkas) {}

    /** Riwayat prestasi milik mahasiswa yang login (F-07, F-09, F-10, F-11, Lap. hal. 110-111). */
    public function index(Request $request): View|StreamedResponse
    {
        $status = $request->input('status');
        $q = $request->input('q');

        $baseQuery = Prestasi::query()
            ->where('id_mahasiswa', $request->user()->id);

        $totalPrestasi = (clone $baseQuery)->count();
        $terverifikasi = (clone $baseQuery)->where('status_verifikasi', 'terverifikasi')->count();
        $dalamProses = (clone $baseQuery)->where('status_verifikasi', 'menunggu')->count();
        $perluPerbaikan = (clone $baseQuery)->where('status_verifikasi', 'perlu_perbaikan')->count();

        $query = (clone $baseQuery)
            ->when($status, fn ($b) => $b->where('status_verifikasi', $status))
            ->when($q, function ($b) use ($q) {
                $b->where(function ($sub) use ($q) {
                    $sub->where('nama_prestasi', 'like', "%{$q}%")
                        ->orWhere('penyelenggara', 'like', "%{$q}%");
                });
            });

        if ($request->input('export') === 'excel') {
            $data = (clone $query)->orderByDesc('tahun_perolehan')->get();

            return response()->streamDownload(function () use ($data) {
                $out = fopen('php://output', 'w');
                fwrite($out, "\xEF\xBB\xBF");
                fputcsv($out, ['No', 'Nama Prestasi', 'Kategori', 'Tingkat', 'Tahun', 'Penyelenggara', 'Perolehan', 'Status', 'Skor']);

                foreach ($data as $i => $item) {
                    fputcsv($out, [
                        $i + 1,
                        $item->nama_prestasi,
                        Prestasi::JENIS[$item->jenis_prestasi] ?? $item->jenis_prestasi,
                        Prestasi::TINGKAT[$item->tingkat_prestasi] ?? $item->tingkat_prestasi,
                        $item->tahun_perolehan,
                        $item->penyelenggara,
                        Prestasi::PEROLEHAN[$item->perolehan] ?? $item->perolehan,
                        Prestasi::STATUS[$item->status_verifikasi] ?? $item->status_verifikasi,
                        $item->skor ?? '-',
                    ]);
                }
                fclose($out);
            }, 'riwayat_prestasi_saya_'.date('Ymd_His').'.csv', [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }

        $prestasi = $query
            ->withCount('dokumentasi')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.prestasi.index', compact(
            'prestasi',
            'status',
            'q',
            'totalPrestasi',
            'terverifikasi',
            'dalamProses',
            'perluPerbaikan'
        ));
    }

    public function create(): View
    {
        return view('mahasiswa.prestasi.create');
    }

    public function store(StorePrestasiRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $baru = [];

        try {
            $prestasi = DB::transaction(function () use (
                $request,
                $data,
                $user,
                &$baru
            ) {
                $prestasi = Prestasi::create([
                    'id_mahasiswa' => $user->id,
                    'nama_prestasi' => $data['nama_prestasi'],
                    'jenis_prestasi' => $data['jenis_prestasi'],
                    'tingkat_prestasi' => $data['tingkat_prestasi'],
                    'perolehan' => $data['perolehan'],
                    'tahun_perolehan' => $data['tahun_perolehan'],
                    'tahun_penyelenggaraan' => $data['tahun_penyelenggaraan'] ?? $data['tahun_perolehan'],
                    'penyelenggara' => $data['penyelenggara'],
                    'tempat_pelaksanaan' => $data['tempat_pelaksanaan'] ?? null,
                    'deskripsi' => $data['deskripsi'] ?? null,
                    'status_verifikasi' => 'menunggu',
                ]);

                $this->berkas->simpanSertifikat(
                    $prestasi,
                    $request->file('sertifikat'),
                    $baru
                );

                $this->berkas->simpanDokumentasi(
                    $prestasi,
                    array_filter($request->file('dokumentasi') ?? []),
                    $data['keterangan_dokumentasi'] ?? [],
                    $baru
                );

                return $prestasi;
            });
        } catch (\Throwable $e) {
            // Transaksi DB di-rollback otomatis; berkas yang sudah tertulis dihapus.
            $this->berkas->hapus($baru);

            throw $e;
        }

        return redirect()
            ->route('mahasiswa.prestasi.show', $prestasi)
            ->with('success', 'Prestasi berhasil diajukan dan menunggu verifikasi Admin.');
    }

    public function show(Request $request, Prestasi $prestasi): View
    {
        Gate::authorize('view', $prestasi);

        abort_unless(
            (int) $prestasi->id_mahasiswa === (int) $request->user()->id,
            403
        );

        $prestasi->load(['sertifikat', 'dokumentasi', 'verifikator']);

        // Activity 2.5: notifikasi terkait ditandai sudah dibaca saat detail dibuka.
        Notifikasi::query()
            ->where('id_user', $request->user()->id)
            ->where('id_prestasi', $prestasi->id)
            ->whereNull('dibaca_pada')
            ->update(['dibaca_pada' => now()]);

        return view('mahasiswa.prestasi.show', compact('prestasi'));
    }

    /** Form perbaikan - hanya untuk status "Perlu Perbaikan" (F-13). */
    public function edit(Prestasi $prestasi): View
    {
        Gate::authorize('update', $prestasi);

        $prestasi->load(['sertifikat', 'dokumentasi']);

        return view('mahasiswa.prestasi.edit', compact('prestasi'));
    }

    public function update(
        UpdatePrestasiRequest $request,
        Prestasi $prestasi
    ): RedirectResponse {
        Gate::authorize('update', $prestasi);

        $data = $request->validated();
        $baru = [];
        $lama = [];

        try {
            DB::transaction(function () use (
                $request,
                $data,
                $prestasi,
                &$baru,
                &$lama
            ) {
                $locked = Prestasi::query()
                    ->whereKey($prestasi->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    (int) $locked->id_mahasiswa !== (int) $request->user()->id
                    || $locked->status_verifikasi !== 'perlu_perbaikan'
                ) {
                    throw ValidationException::withMessages([
                        'prestasi' => 'Hanya pengajuan milik sendiri yang '
                            .'berstatus Perlu Perbaikan yang dapat diubah.',
                    ]);
                }

                // Diajukan ulang -> kembali ke antrean verifikasi.
                // catatan_revisi lama sengaja dipertahankan agar Admin bisa
                // memeriksa apakah catatannya sudah ditindaklanjuti.
                $locked->update([
                    'nama_prestasi' => $data['nama_prestasi'],
                    'jenis_prestasi' => $data['jenis_prestasi'],
                    'tingkat_prestasi' => $data['tingkat_prestasi'],
                    'perolehan' => $data['perolehan'],
                    'tahun_perolehan' => $data['tahun_perolehan'],
                    'tahun_penyelenggaraan' => $data['tahun_penyelenggaraan'] ?? $data['tahun_perolehan'],
                    'penyelenggara' => $data['penyelenggara'],
                    'tempat_pelaksanaan' => $data['tempat_pelaksanaan'] ?? null,
                    'deskripsi' => $data['deskripsi'] ?? null,
                    'status_verifikasi' => 'menunggu',
                    'skor' => null,
                    'id_admin' => null,
                    'diverifikasi_pada' => null,
                ]);

                // Sertifikat: ganti hanya bila ada unggahan baru.
                if ($request->hasFile('sertifikat')) {
                    $lama = array_merge(
                        $lama,
                        $locked->sertifikat()->pluck('file_sertifikat')->all()
                    );

                    $locked->sertifikat()->delete();

                    $this->berkas->simpanSertifikat(
                        $locked,
                        $request->file('sertifikat'),
                        $baru
                    );
                }

                // Dokumentasi: hapus yang dipilih, lalu tambahkan yang baru.
                $hapusIds = array_map('intval', $data['hapus_dokumentasi'] ?? []);

                if ($hapusIds !== []) {
                    $dihapus = $locked->dokumentasi()
                        ->whereIn('id', $hapusIds)
                        ->get();

                    foreach ($dihapus as $dok) {
                        $lama[] = $dok->file_dokumentasi;
                        $dok->delete();
                    }
                }

                $fileBaru = array_filter($request->file('dokumentasi') ?? []);

                if (
                    $locked->dokumentasi()->count() + count($fileBaru)
                    > self::MAKS_DOKUMENTASI
                ) {
                    throw ValidationException::withMessages([
                        'dokumentasi' => 'Maksimal '.self::MAKS_DOKUMENTASI
                            .' file dokumentasi per prestasi.',
                    ]);
                }

                $this->berkas->simpanDokumentasi(
                    $locked,
                    $fileBaru,
                    $data['keterangan_dokumentasi'] ?? [],
                    $baru
                );
            });
        } catch (\Throwable $e) {
            $this->berkas->hapus($baru);

            throw $e;
        }

        // Berkas lama baru dihapus setelah transaksi sukses.
        $this->berkas->hapus($lama);

        return redirect()
            ->route('mahasiswa.prestasi.show', $prestasi)
            ->with('success', 'Perbaikan berhasil dikirim ulang dan menunggu verifikasi.');
    }
}
