@extends('layouts.main')

@section('content')
<h3>Konfirmasi Barang</h3>

<table class="table">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp

        @foreach($barangDipilih as $b)
        <tr>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ number_format($b->harga, 0, ',', '.') }}</td>
        </tr>
        @php $total += $b->harga; @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Total</th>
            <th>{{ number_format($total, 0, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>

<hr>
<h4>Posisi Mulai Cetak</h4>

<form action="{{ route('user.barang.cetak') }}" method="POST">
@csrf

@foreach($barangDipilih as $b)
    <input type="hidden" name="barang[]" value="{{ $b->id_barang }}">
@endforeach

<label>Mulai Kolom (X) [1–5]</label><br>
<input type="number" name="x" min="1" max="5" required><br><br>

<label>Mulai Baris (Y) [1–8]</label><br>
<input type="number" name="y" min="1" max="8" required><br><br>

<button type="submit">Cetak PDF</button>
</form>

<form action="{{ route('user.barang.cetak') }}" method="POST">
@csrf


@endsection