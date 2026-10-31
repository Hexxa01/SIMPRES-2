@extends('layout.app')

@section('title', 'Data Mahasiswa')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h1 class="h4 mb-0">Data Mahasiswa</h1>
        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">+ Tambah Mahasiswa</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-5">
            <input type="search" name="q" value="{{ $f['q'] ?? '' }}" class="form-control"
                placeholder="Cari nama atau NIM" aria-label="Cari nama atau NIM">
        </div>
        <div class="col-md-4">
            <select name="prodi" class="form-select" aria-label="Program studi">
                <option value="">Semua program studi</option>
                @foreach ($prodiList as $pr)
                    <option value="{{ $pr }}" @selected(($f['prodi'] ?? '') === $pr)>{{ $pr }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary">Cari</button>
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th class="text-end">Prestasi</th>
                        <th class="text-end">Terverifikasi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $m)
                        <tr>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->prodi ?: '-' }}</td>
                            <td>{{ $m->angkatan ?: '-' }}</td>
                            <td class="text-end">{{ $m->prestasi_count }}</td>
                            <td class="text-end">{{ $m->terverifikasi_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.mahasiswa.show', $m) }}" class="btn btn-sm btn-outline-primary">Riwayat</a>
                                <a href="{{ route('admin.mahasiswa.edit', $m) }}" class="btn btn-sm btn-outline-secondary">Ubah</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Data mahasiswa tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $mahasiswa->links() }}</div>
@endsection
