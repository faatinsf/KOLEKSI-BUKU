@extends('layoutss.main')

@section('content')
<h3>Data Barang</h3>

<a href="{{ route('admin.barang.create') }}">Tambah Barang</a>

<table id="tabelBarang" class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barang as $b)
        <tr>
            <td>{{ $b->id_barang }}</td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->harga }}</td>
            <td>
                <a href="{{ route('admin.barang.edit',$b->id_barang) }}">Edit</a>
                <form method="POST" action="{{ route('admin.barang.destroy',$b->id_barang) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('scripts')
<link rel="stylesheet"
 href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#tabelBarang').DataTable();
});
</script>
@endsection