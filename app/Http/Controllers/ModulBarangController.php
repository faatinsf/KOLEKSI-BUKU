<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModulBarangController extends Controller
{
    public function index()
    {
        return view('admin.modulbarang.halamansatubarang');
    }

    public function halamanDua()
    {
        return view('admin.modulbarang.halamanduabarang');
    }

        public function halamanTiga()
    {
        return view('admin.modulbarang.halamantigabarang');
    }

}
