@extends('layoutss.main')

@section('title', 'Tambah Buku')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">➕ Tambah Buku</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.buku.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Kode Buku</label>
                    <input type="text" name="kode" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="idkategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->idkategori }}">
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-maroon">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
