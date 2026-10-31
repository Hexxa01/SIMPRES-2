@extends('layout.app')

@section('title', 'Tambah Data Prestasi')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1e293b;">Tambah Data Prestasi</h4>
            <p class="text-muted mb-0 small">Masukkan data prestasi yang Anda peroleh beserta bukti sertifikat & dokumentasi</p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.prestasi.index') }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
            </a>
        </div>
    </div>

    @include('mahasiswa.prestasi._form', [
        'action' => route('mahasiswa.prestasi.store'),
        'method' => 'POST',
        'prestasi' => null,
        'submitLabel' => 'Simpan Prestasi',
    ])
</div>
@endsection
