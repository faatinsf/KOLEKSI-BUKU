<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Vendor\VendorMenuController;

class VendorMenuController extends Controller
{
    private function getVendor()
    {
        return Vendor::where('user_id', auth()->id())->firstOrFail();
    }

    public function index()
    {
        $vendor = $this->getVendor();
        $menus  = $vendor->menus()->latest()->get();

        return view('vendor.menu.index', compact('menus', 'vendor'));
    }

    public function create()
    {
        return view('vendor.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga'     => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $vendor = $this->getVendor();

        $vendor->menus()->create($request->only('nama_menu', 'harga', 'deskripsi'));

        return redirect()->route('vendor.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $this->authorizeMenu($menu);

        return view('vendor.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $this->authorizeMenu($menu);

        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga'     => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $menu->update($request->only('nama_menu', 'harga', 'deskripsi'));

        return redirect()->route('vendor.menu.index')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        $this->authorizeMenu($menu);
        $menu->delete();

        return redirect()->route('vendor.menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    private function authorizeMenu(Menu $menu)
    {
        $vendor = $this->getVendor();
        if ($menu->vendor_id !== $vendor->id) {
            abort(403);
        }
    }
}
