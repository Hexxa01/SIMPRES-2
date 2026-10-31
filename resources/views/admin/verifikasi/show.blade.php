@extends('layout.app')

@section('title', 'Verifikasi: ' . $prestasi->nama_prestasi)

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1e293b;">Pemeriksaan &amp; Verifikasi Prestasi</h4>
            <p class="text-muted mb-0 small">Periksa keabsahan bukti sertifikat, dokumentasi, dan tentukan status verifikasi</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Prestasi
            </a>
        </div>
    </div>

    <!-- Alert Status -->
    @if ($prestasi->status_verifikasi === 'menunggu')
        <div class="alert alert-warning border-0 rounded-4 p-3 mb-4 shadow-sm d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-hourglass-split fs-3 text-warning"></i>
                <div>
                    <strong>Berkas Menunggu Verifikasi!</strong><br>
                    <span class="small">Silakan lakukan pemeriksaan terhadap bukti pendukung di bawah dan isi formulir keputusan di bagian bawah halaman.</span>
                </div>
            </div>
            <a href="#verifikasi-box" class="btn btn-sm btn-warning fw-semibold rounded-3 text-dark px-3">
                Langsung ke Verifikasi ↓
            </a>
        </div>
    @elseif ($prestasi->status_verifikasi === 'terverifikasi')
        <div class="alert alert-success border-0 rounded-4 p-3 mb-4 shadow-sm d-flex align-items-center gap-3">
            <i class="bi bi-check-circle-fill fs-3 text-success"></i>
            <div>
                <strong>Prestasi Sudah Terverifikasi</strong><br>
                <span class="small">Skor: <strong>{{ $prestasi->skorTampil() }}</strong> oleh {{ $prestasi->verifikator->nama ?? 'Admin' }} pada {{ $prestasi->diverifikasi_pada ? $prestasi->diverifikasi_pada->format('d/m/Y H:i') : '-' }}.</span>
            </div>
        </div>
    @elseif ($prestasi->status_verifikasi === 'perlu_perbaikan')
        <div class="alert alert-danger border-0 rounded-4 p-3 mb-4 shadow-sm d-flex align-items-center gap-3">
            <i class="bi bi-exclamation-triangle-fill fs-3 text-danger"></i>
            <div>
                <strong>Status: Perlu Perbaikan</strong><br>
                <span class="small">Mahasiswa sedang memperbaiki data sesuai catatan perbaikan yang Anda berikan.</span>
            </div>
        </div>
    @endif

    <!-- Data & Berkas Preview -->
    @include('partials.detail-prestasi', ['prestasi' => $prestasi])

    <!-- Box Form Verifikasi (Lap. hal. 119-122) -->
    <div class="content-card mt-4" id="verifikasi-box" style="border: 2px solid var(--simpres-olive);">
        <div class="content-card-header">
            <h5 class="content-card-title">
                <i class="bi bi-patch-check-fill" style="color: var(--simpres-olive);"></i> Keputusan Verifikasi &amp; Penilaian Admin
            </h5>
            @include('partials.status-badge', ['prestasi' => $prestasi])
        </div>

        @can('verify', $prestasi)
            <form action="{{ route('admin.verifikasi.proses', $prestasi) }}" method="POST" id="form-verifikasi">
                @csrf
                @method('PATCH')

                <div class="row g-4">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold" for="status_verifikasi">
                            Tentukan Status Verifikasi <span class="text-danger">*</span>
                        </label>
                        <select name="status_verifikasi" id="status_verifikasi" class="form-select @error('status_verifikasi') is-invalid @enderror" required onchange="toggleFormFields()">
                            <option value="">- Pilih Keputusan -</option>
                            <option value="terverifikasi" @selected(old('status_verifikasi') === 'terverifikasi')>
                                ✅ Terverifikasi (Data Sah & Sesuai)
                            </option>
                            <option value="perlu_perbaikan" @selected(old('status_verifikasi') === 'perlu_perbaikan')>
                                ✏️ Perlu Perbaikan (Ada data/dokumen yang perlu direvisi)
                            </option>
                            <option value="ditolak" @selected(old('status_verifikasi') === 'ditolak')>
                                ❌ Ditolak (Tidak memenuhi syarat)
                            </option>
                        </select>
                        <div class="form-text small mt-2">
                            Pilih status berdasarkan hasil pemeriksaan kelengkapan dokumen pendukung dan kesesuaian informasi.
                        </div>
                    </div>

                    <!-- Panel Memberikan Skor (Lap. hal. 119-120) -->
                    <div class="col-md-7" id="panel-skor" style="display: none;">
                        <div class="p-3 rounded-4 bg-light border">
                            <h6 class="fw-bold text-success mb-2">
                                <i class="bi bi-star-fill text-warning me-1"></i> Berikan Skor Prestasi (0 - 100)
                            </h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold" for="skor">Nilai / Skor Prestasi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" max="100" name="skor" id="skor"
                                        value="{{ old('skor', 90) }}" class="form-control @error('skor') is-invalid @enderror" placeholder="Contoh: 95">
                                    <span class="input-group-text">/ 100</span>
                                </div>
                                <div class="form-text small">Skor diberikan sesuai dengan ketentuan penilaian yang berlaku di Fakultas Sains dan Teknologi.</div>
                            </div>
                            <div>
                                <label class="form-label small fw-semibold" for="catatan_skor">Catatan Penilaian (Opsional)</label>
                                <textarea name="catatan_skor" id="catatan_skor" rows="2" class="form-control" placeholder="Apresiasi atau keterangan nilai..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Catatan Perbaikan (Lap. hal. 121-122) -->
                    <div class="col-md-7" id="panel-catatan-perbaikan" style="display: none;">
                        <div class="p-3 rounded-4 bg-light border border-danger-subtle">
                            <h6 class="fw-bold text-danger mb-2">
                                <i class="bi bi-chat-left-dots-fill text-danger me-1"></i> Berikan Catatan Perbaikan
                            </h6>
                            <label class="form-label small fw-bold" for="catatan_revisi">
                                Rincian Perbaikan yang Harus Dilakukan Mahasiswa <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan_revisi" id="catatan_revisi" rows="4" maxlength="5000"
                                class="form-control @error('catatan_revisi') is-invalid @enderror"
                                placeholder="Contoh: Sertifikat yang diunggah buram/kurang jelas. Mohon unggah ulang file sertifikat asli dalam format PDF.">{{ old('catatan_revisi') }}</textarea>
                            <div class="form-text small text-danger">Catatan ini akan dikirimkan sebagai notifikasi kepada mahasiswa untuk memperbaiki berkasnya.</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-olive px-5 py-2 rounded-3 fw-bold shadow">
                        <i class="bi bi-save me-1"></i> Simpan Keputusan Verifikasi
                    </button>
                </div>
            </form>
        @else
            <div class="p-3 bg-light rounded-3 text-muted">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                    <span>Pengajuan prestasi ini telah diproses atau saat ini sedang dalam status <strong>{{ $prestasi->statusLabel() }}</strong>.</span>
                </div>
            </div>

            @can('delete', $prestasi)
                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <form action="{{ route('admin.verifikasi.destroy', $prestasi) }}" method="POST"
                        onsubmit="return confirm('Hapus data prestasi ini beserta berkasnya? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger rounded-3 btn-sm">
                            <i class="bi bi-trash me-1"></i> Hapus Data Prestasi Ini
                        </button>
                    </form>
                </div>
            @endcan
        @endcan
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleFormFields() {
        const select = document.getElementById('status_verifikasi');
        const panelSkor = document.getElementById('panel-skor');
        const panelCatatan = document.getElementById('panel-catatan-perbaikan');
        const inputSkor = document.getElementById('skor');
        const inputCatatan = document.getElementById('catatan_revisi');

        if (!select) return;

        const val = select.value;
        if (val === 'terverifikasi') {
            panelSkor.style.display = 'block';
            panelCatatan.style.display = 'none';
            if (inputSkor) inputSkor.required = true;
            if (inputCatatan) inputCatatan.required = false;
        } else if (val === 'perlu_perbaikan' || val === 'ditolak') {
            panelSkor.style.display = 'none';
            panelCatatan.style.display = 'block';
            if (inputSkor) inputSkor.required = false;
            if (inputCatatan) inputCatatan.required = true;
        } else {
            panelSkor.style.display = 'none';
            panelCatatan.style.display = 'none';
            if (inputSkor) inputSkor.required = false;
            if (inputCatatan) inputCatatan.required = false;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleFormFields();
    });
</script>
@endpush
