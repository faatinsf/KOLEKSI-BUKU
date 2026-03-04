<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('admin.barang.index', compact('barang'));
    }

    public function create()
    {
        return view('admin.barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
        ]);

        Barang::create($request->only('nama_barang','harga','deskripsi'));

        return redirect()->route('admin.barang.index')
            ->with('success','Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
        ]);

        Barang::findOrFail($id)
            ->update($request->only('nama_barang','harga','deskripsi'));

        return redirect()->route('admin.barang.index')
            ->with('success','Barang berhasil diupdate');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();
        return redirect()->route('admin.barang.index')
            ->with('success','Barang berhasil dihapus');
    }
}