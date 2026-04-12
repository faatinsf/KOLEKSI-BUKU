<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tag Harga TNJ 108</title>

<style>
@page {
    margin: 0;
}

body {
    margin: 0;
    background-color: #ffffff;
    width: 210mm;
    height: 167mm;
}

table {
    border-collapse: separate;
    border-spacing: 2mm 2mm;
    margin: 0 auto;
}

td {
    width: 38mm;
    height: 18mm;
    background: #ffffff;
    border: 0.3px solid #000;
    border-radius: 10px;
    text-align: center;
    vertical-align: middle;
}

.barcode img {
    width: 34mm;
    height: 12mm;
    display: block;
    margin: 0 auto;
}

.kode {
    font-size: 6pt;
}
</style>
</head>

<body>
<table>

@for ($row = 0; $row < 8; $row++)
<tr>
    @for ($col = 0; $col < 5; $col++)
        @php
            $index = ($row * 5) + $col;
            $item  = $labels[$index] ?? null;
        @endphp

        <td>
            @if($item)
                <div class="barcode">
                    <img src="{{ $barcodes[$item->id_barang] }}" alt="barcode">
                </div>
                <div class="kode">{{ $item->id_barang }}</div>
            @endif
        </td>

    @endfor
</tr>
@endfor

</table>
</body>
</html>