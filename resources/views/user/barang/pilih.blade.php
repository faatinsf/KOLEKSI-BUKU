@extends('layouts.main')

@section('content')
<h3>Pilih Barang untuk di cetak tag harga</h3>

<form action="{{ route('user.barang.proses') }}" method="POST">
@csrf

<table class="table" id="tabelBarangUser">
    <thead>
        <tr>
            <th>Pilih</th>
            <th>Nama</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barang as $b)
        <tr>
            <td>
                <input type="checkbox" name="barang[]" value="{{ $b->id_barang }}">
            </td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->harga }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<button type="submit">Lanjut</button>
</form>


@endsection

