@extends('layoutss.main')

@section('title', 'Edit Buku')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">✏️ Edit Buku</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.buku.update', $buku->idbuku) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Kode Buku</label>
                    <input type="text" name="kode" value="{{ $buku->kode }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="{{ $buku->judul }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" value="{{ $buku->pengarang }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="idkategori" class="form-control" required>
                        @foreach($kategori as $k)
                            <option value="{{ $k->idkategori }}"
                                {{ $buku->idkategori == $k->idkategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-maroon">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
