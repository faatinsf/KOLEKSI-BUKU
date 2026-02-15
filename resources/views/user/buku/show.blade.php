@extends('layouts.main')

@section('title', 'Detail Buku')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">📖 Detail Buku</h4>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <tr>
                    <th width="200">Kode</th>
                    <td>{{ $buku->kode }}</td>
                </tr>
                <tr>
                    <th>Judul</th>
                    <td>{{ $buku->judul }}</td>
                </tr>
                <tr>
                    <th>Pengarang</th>
                    <td>{{ $buku->pengarang }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                </tr>
            </table>

            <a href="{{ route('user.buku.index') }}" class="btn btn-warning btn-sm">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
