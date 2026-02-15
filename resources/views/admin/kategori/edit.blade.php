@extends('layoutss.main')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">✏️ Edit Kategori</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kategori.update', $kategori->idkategori) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Kode Kategori</label>
                    <input type="text" name="idkategori" value="{{ $kategori->idkategori }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" class="form-control" required>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-maroon">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
