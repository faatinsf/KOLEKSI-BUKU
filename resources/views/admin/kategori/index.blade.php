@extends('layoutss.main')

@section('title', 'Data Kategori')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📚 Data Kategori</h4>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-maroon">
            + Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-maroon">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Kategori</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategori as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->idkategori }}</td>
                        <td>{{ $item->nama_kategori }}</td>
                        <td>
                            <a href="{{ route('admin.kategori.show', $item->idkategori) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.kategori.edit', $item->idkategori) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.kategori.destroy', $item->idkategori) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus kategori ini?')" class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($kategori->count() == 0)
                    <tr>
                        <td colspan="6" class="text-center">Data kategori kosong</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
