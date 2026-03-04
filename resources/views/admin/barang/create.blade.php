@extends('layoutss.main')

@section('content')
<h2>Tambah Barang</h2>

<form action="{{ route('admin.barang.store') }}" method="POST">
@csrf
<input type="text" name="nama_barang" placeholder="Nama Barang"><br>
<input type="number" name="harga" placeholder="Harga"><br>
<textarea name="deskripsi" placeholder="Deskripsi"></textarea><br>
<button type="submit">Simpan</button>
</form>
@endsection