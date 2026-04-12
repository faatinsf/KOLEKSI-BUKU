<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarangUserController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('user.barang.index', compact('barang'));
    }


 // ganti SVG → PNG

public function cetak(Request $request)
{
    $barangIds = $request->input('barang', []);
    $x = (int) $request->input('x', 1);
    $y = (int) $request->input('y', 1);

    $barangDipilih = \App\Models\Barang::whereIn('id_barang', $barangIds)->get();

    // Generate barcode PNG → base64
    $generator = new BarcodeGeneratorPNG();
    $barcodes  = [];
    foreach ($barangDipilih as $b) {
        $png = $generator->getBarcode(
            (string) $b->id_barang,
            $generator::TYPE_CODE_128,
            1,   // lebar bar
            30   // tinggi bar
        );
        $barcodes[$b->id_barang] = 'data:image/png;base64,' . base64_encode($png);
    }

    // Hitung posisi mulai
    $startIndex = (($y - 1) * 5) + ($x - 1);
    $labels = [];
    for ($i = 0; $i < $startIndex; $i++) {
        $labels[] = null;
    }
    foreach ($barangDipilih as $b) {
        $labels[] = $b;
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.barang.tag-harga', [
        'labels'   => $labels,
        'barcodes' => $barcodes,
    ])->setPaper([0, 0, 595, 475], 'portrait');

    return $pdf->stream('tag-harga.pdf');
}
    public function pilih()
    {
        $barang = Barang::all();
        return view('user.barang.pilih', compact('barang'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'barang' => 'required|array'
        ]);

        $barangDipilih = Barang::whereIn('id_barang', $request->barang)->get();

        return view('user.barang.konfirmasi', compact('barangDipilih'));

}

}