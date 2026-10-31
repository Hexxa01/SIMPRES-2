@extends('layout.app')

@section('title', 'Ubah Mahasiswa')

@section('content')
    <h1 class="h4 mb-3">Ubah Data Mahasiswa</h1>

    @include('admin.mahasiswa._form', [
        'action' => route('admin.mahasiswa.update', $mahasiswa),
        'method' => 'PUT',
        'mahasiswa' => $mahasiswa,
        'submitLabel' => 'Simpan Perubahan',
    ])
@endsection
