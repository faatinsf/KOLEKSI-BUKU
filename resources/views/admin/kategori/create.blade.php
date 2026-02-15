@extends('layoutss.main')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">➕ Tambah Kategori</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Kode Kategori</label>
                    <input type="text" name="idkategori" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" required>
                </div>


                <div class="text-end">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-maroon">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
