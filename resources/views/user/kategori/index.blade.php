@extends('layouts.main')

@section('title', 'Data Kategori')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📚 Data Kategori</h4>

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
                            <a href="{{ route('user.kategori.show', $item->idkategori) }}" class="btn btn-info btn-sm">Detail</a>
                           
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
