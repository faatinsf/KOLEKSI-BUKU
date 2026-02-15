<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        $totalBuku = DB::table('buku')->count();
        $totalKategori = DB::table('kategori')->count();

        return view('user.dashboard', compact(
            'totalBuku',
            'totalKategori'
        ));
    }
}
