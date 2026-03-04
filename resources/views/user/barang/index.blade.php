@extends('layouts.main')

@section('content')
<h3>Daftar Barang</h3>

<table class="table">
<tr>
    <th>Nama</th>
    <th>Harga</th>
</tr>
@foreach($barang as $b)
<tr>
    <td>{{ $b->nama_barang }}</td>
    <td>{{ $b->harga }}</td>
</tr>
@endforeach
</table>
@endsection