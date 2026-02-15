@extends('layoutss.main')

@section('title', 'Data Buku')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📚 Data Buku</h4>
        <a href="{{ route('admin.buku.create') }}" class="btn btn-maroon">
            + Tambah Buku
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
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->pengarang }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.buku.show', $item->idbuku) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.buku.edit', $item->idbuku) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.buku.destroy', $item->idbuku) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus buku ini?')" class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($buku->count() == 0)
                    <tr>
                        <td colspan="6" class="text-center">Data buku kosong</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
