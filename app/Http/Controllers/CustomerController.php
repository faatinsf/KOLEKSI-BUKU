<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('user.customer.index', compact('customers'));
    }

    public function tambah1()
    {
        return view('user.customer.tambah1');
    }

    public function simpan1(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'nullable|email',
            'telepon'  => 'nullable|string|max:20',
            'foto_blob' => 'required|string', // base64 data URL
        ]);

        // Simpan base64 langsung sebagai blob
        Customer::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'telepon'   => $request->telepon,
            'foto_blob' => $request->foto_blob,
        ]);

        return redirect()->route('user.customer.index')
                         ->with('success', 'Customer berhasil ditambahkan (blob)!');
    }

    public function tambah2()
    {
        return view('user.customer.tambah2');
    }

    public function simpan2(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'telepon' => 'nullable|string|max:20',
            'foto'    => 'required|string', // base64 dari kamera
        ]);

        // Decode base64 dan simpan sebagai file
        $base64 = $request->foto;
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        $fileName  = 'customer_' . time() . '.jpg';
        $filePath  = 'customers/' . $fileName;

        Storage::disk('public')->put($filePath, $imageData);

        Customer::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'telepon'   => $request->telepon,
            'foto_path' => $filePath,
        ]);

        return redirect()->route('user.customer.index')
                         ->with('success', 'Customer berhasil ditambahkan (file)!');
    }
}