@extends('layoutss.main')

@section('content')
<h2>Edit Barang</h2>

<form action="{{ route('admin.barang.update', $barang->id_barang) }}" method="POST">
@csrf
@method('PUT')
<input type="text" name="nama_barang" value="{{ $barang->nama_barang }}"><br>
<input type="number" name="harga" value="{{ $barang->harga }}"><br>
<textarea name="deskripsi">{{ $barang->deskripsi }}</textarea><br>
<button type="submit">Update</button>
</form>
@endsection