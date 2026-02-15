@extends('layoutss.main')

@section('title', 'Detail Kategori')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">📖 Detail Kategori</h4>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <tr>
                    <th width="200">Kode</th>
                    <td>{{ $kategori->idkategori }}</td>
                </tr>
                <tr>
                    <th>Nama Kategori</th>
                    <td>{{ $kategori->nama_kategori }}</td>
                </tr>
            </table>

            <a href="{{ route('admin.kategori.index') }}" class="btn btn-warning btn-sm">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
