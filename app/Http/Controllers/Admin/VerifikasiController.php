<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifikasiPrestasiRequest;
use App\Models\Notifikasi;
use App\Models\Prestasi;
use App\Models\User;
use App\Services\BerkasPrestasiService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class VerifikasiController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private BerkasPrestasiService $berkas) {}

    /** Data prestasi: pencarian & filter (F-17, F-26, F-27). */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'prodi' => ['nullable', 'string', 'max:100'],
            'status_verifikasi' => ['nullable', Rule::in(array_keys(Prestasi::STATUS))],
            'jenis_prestasi' => ['nullable', Rule::in(array_keys(Prestasi::JENIS))],
            'tingkat_prestasi' => ['nullable', Rule::in(array_keys(Prestasi::TINGKAT))],
            'perolehan' => ['nullable', Rule::in(array_keys(Prestasi::PEROLEHAN))],
            'tahun_perolehan' => ['nullable', 'integer', 'min:1900', 'max:'.now()->year],
            'skor_min' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'skor_max' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $prestasi = Prestasi::query()
            ->with('mahasiswa:id,nama,nim,prodi,angkatan')
            ->filterData($filters)
            ->cari($filters['q'] ?? null, $filters['prodi'] ?? null)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $prodiList = User::query()
            ->where('role', 'mahasiswa')
            ->whereNotNull('prodi')
            ->distinct()
            ->orderBy('prodi')
            ->pluck('prodi');

        return view('admin.verifikasi.index', compact('prestasi', 'prodiList', 'filters'));
    }

    /** Detail prestasi + sertifikat + dokumentasi (F-18, F-19, F-20). */
    public function show(Prestasi $prestasi): View
    {
        $this->authorize('view', $prestasi);

        $prestasi->load([
            'mahasiswa:id,nama,nim,prodi,angkatan,email,no_hp',
            'sertifikat',
            'dokumentasi',
            'verifikator',
        ]);

        return view('admin.verifikasi.show', compact('prestasi'));
    }

    /** Verifikasi: status, skor, catatan perbaikan + notifikasi (F-22 s.d. F-25, F-42). */
    public function verifikasi(
        VerifikasiPrestasiRequest $request,
        Prestasi $prestasi
    ): RedirectResponse {
        $this->authorize('verify', $prestasi);

        $data = $request->validated();
        $adminId = $request->user()->admin?->id;

        DB::transaction(function () use ($data, $prestasi, $adminId) {
            $locked = Prestasi::query()
                ->whereKey($prestasi->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->status_verifikasi !== 'menunggu') {
                throw ValidationException::withMessages([
                    'status_verifikasi' => 'Pengajuan ini sudah diproses atau sedang direvisi.',
                ]);
            }

            $status = $data['status_verifikasi'];
            $skor = $status === 'terverifikasi' ? $data['skor'] : null;
            $catatan = in_array($status, ['ditolak', 'perlu_perbaikan'], true)
                ? $data['catatan_revisi']
                : null;

            $locked->update([
                'status_verifikasi' => $status,
                'skor' => $skor,
                'catatan_revisi' => $catatan,
                'id_admin' => $adminId,
                'diverifikasi_pada' => now(),
            ]);

            [$judul, $pesan] = $this->isiNotifikasi($locked, $status, $skor, $catatan);

            Notifikasi::create([
                'id_user' => $locked->id_mahasiswa,
                'id_prestasi' => $locked->id,
                'judul' => $judul,
                'pesan' => $pesan,
            ]);
        });

        return redirect()
            ->route('admin.verifikasi.show', $prestasi)
            ->with('success', 'Verifikasi tersimpan dan notifikasi telah dikirim ke mahasiswa.');
    }

    public function destroy(Prestasi $prestasi): RedirectResponse
    {
        $this->authorize('delete', $prestasi);

        DB::transaction(fn () => $prestasi->delete());

        $this->berkas->hapusFolder($prestasi);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', 'Data prestasi dihapus.');
    }

    /** @return array{0:string,1:string} */
    private function isiNotifikasi(
        Prestasi $prestasi,
        string $status,
        mixed $skor,
        ?string $catatan
    ): array {
        $nama = '"'.$prestasi->nama_prestasi.'"';

        return match ($status) {
            'terverifikasi' => [
                'Prestasi terverifikasi',
                "Prestasi {$nama} telah diverifikasi dengan skor "
                    .number_format((float) $skor, 2, ',', '.').'.',
            ],
            'perlu_perbaikan' => [
                'Prestasi perlu diperbaiki',
                "Prestasi {$nama} perlu diperbaiki. Catatan Admin: {$catatan}",
            ],
            default => [
                'Prestasi ditolak',
                "Prestasi {$nama} ditolak. Catatan Admin: {$catatan}",
            ],
        };
    }
}
