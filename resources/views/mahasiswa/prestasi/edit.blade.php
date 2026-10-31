@extends('layout.app')

@section('title', 'Perbaikan Data Prestasi')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1e293b;">Halaman Perbaikan Data Prestasi</h4>
            <p class="text-muted mb-0 small">Perbaiki informasi atau unggah ulang dokumen sesuai catatan verifikasi dari Admin</p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.prestasi.show', $prestasi) }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Batal / Kembali ke Detail
            </a>
        </div>
    </div>

    @include('mahasiswa.prestasi._form', [
        'action' => route('mahasiswa.prestasi.update', $prestasi),
        'method' => 'PUT',
        'prestasi' => $prestasi,
        'submitLabel' => 'Kirim Perbaikan untuk Diverifikasi Ulang',
    ])
</div>
@endsection
