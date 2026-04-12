@extends('layoutsv.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Master Menu — {{ $vendor->nama_vendor }}</h3>
    <a href="{{ route('vendor.menu.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Tambah Menu
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table id="tabelMenu" class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $i => $menu)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $menu->nama_menu }}</td>
                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td>{{ $menu->deskripsi ?? '-' }}</td>
                    <td>
                        <a href="{{ route('vendor.menu.edit', $menu->id) }}" class="btn btn-sm btn-warning">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('vendor.menu.destroy', $menu->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="mdi mdi-delete"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Belum ada menu. <a href="{{ route('vendor.menu.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#tabelMenu').DataTable({ language: { url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' } });
});
</script>
@endsection
