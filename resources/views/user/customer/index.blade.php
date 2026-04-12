@extends('layouts.main')

@section('title', 'Data Customer')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>👥 Data Customer</h4>
            <div>
                <a href="{{ route('user.customer.tambah1') }}" class="btn btn-primary btn-sm">
                    + Tambah (Blob)
                </a>
                <a href="{{ route('user.customer.tambah2') }}" class="btn btn-secondary btn-sm">
                    + Tambah (File)
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Tipe Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($c->foto_blob)
                                <img src="{{ $c->foto_blob }}"
                                     width="60" height="60"
                                     style="object-fit:cover;border-radius:50%;">
                            @elseif($c->foto_path)
                                <img src="{{ Storage::url($c->foto_path) }}"
                                     width="60" height="60"
                                     style="object-fit:cover;border-radius:50%;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $c->nama }}</td>
                        <td>{{ $c->email ?? '-' }}</td>
                        <td>{{ $c->telepon ?? '-' }}</td>
                        <td>
                            @if($c->foto_blob)
                                <span class="badge bg-primary">Blob DB</span>
                            @elseif($c->foto_path)
                                <span class="badge bg-success">File Storage</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data customer</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection