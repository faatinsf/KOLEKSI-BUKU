<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Vendor;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendor       = Vendor::where('user_id', auth()->id())->firstOrFail();
        $totalMenu    = $vendor->menus()->count();
        $totalLunas   = Order::where('vendor_id', $vendor->id)
                            ->where('status_pembayaran', 'lunas')->count();
        $totalPending = Order::where('vendor_id', $vendor->id)
                            ->where('status_pembayaran', 'pending')->count();

        return view('vendor.dashboard', compact('vendor', 'totalMenu', 'totalLunas', 'totalPending'));
    }
}
