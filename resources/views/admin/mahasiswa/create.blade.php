@extends('layout.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
    <h1 class="h4 mb-3">Tambah Akun Mahasiswa</h1>

    @include('admin.mahasiswa._form', [
        'action' => route('admin.mahasiswa.store'),
        'method' => 'POST',
        'mahasiswa' => null,
        'submitLabel' => 'Simpan',
    ])
@endsection
