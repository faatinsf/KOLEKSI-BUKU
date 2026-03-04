<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangUserController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('user.barang.index', compact('barang'));
    }

public function cetak(Request $request)
{
    $request->validate([
        'barang' => 'required|array',
        'x' => 'required|integer|min:1|max:5',
        'y' => 'required|integer|min:1|max:8',  
    ]);

    $barangDipilih = Barang::whereIn('id_barang', $request->barang)->get();

    $startIndex = (($request->y - 1) * 5) + ($request->x - 1);

    $labels = array_fill(0, 40, null);

    foreach ($barangDipilih as $i => $barang) {     
        if ($startIndex + $i < 40) {
            $labels[$startIndex + $i] = $barang;
        }
    }

  
        $pdf = Pdf::loadView('user.barang.pdf', compact('labels'))
          ->setPaper([0,0, 210 * 2.83465, 169 * 2.83465], 'portrait')
          ->setOptions([
              'isHtml5ParserEnabled' => true,
              'isRemoteEnabled' => true,
              'margin_top' => 0,
              'margin_bottom' => 0,
              'margin_left' => 0,
             'margin_right' => 0,
          ]);


    return $pdf->stream('tag-harga-tnj-108.pdf');
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