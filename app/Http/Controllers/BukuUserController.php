<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuUserController extends Controller
{
  

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::with('kategori')->orderBy('idbuku', 'desc')->get();
        return view('user.buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('user.buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|max:20|unique:buku,kode',
            'judul' => 'required|max:500',
            'pengarang' => 'required|max:200',
            'idkategori' => 'required|exists:kategori,idkategori'
        ]);

        Buku::create([
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'idkategori' => $request->idkategori
        ]);

        return redirect()->route('user.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('user.buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();
        return view('user.buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode' => 'required|max:20|unique:buku,kode,' . $id . ',idbuku',
            'judul' => 'required|max:500',
            'pengarang' => 'required|max:200',
            'idkategori' => 'required|exists:kategori,idkategori'
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update([
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'idkategori' => $request->idkategori
        ]);

        return redirect()->route('user.buku.index')
                         ->with('success', 'Buku berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('user.buku.index')
                         ->with('success', 'Buku berhasil dihapus!');
    }
}