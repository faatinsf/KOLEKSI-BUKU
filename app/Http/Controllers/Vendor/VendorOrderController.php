<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;

class VendorOrderController extends Controller
{
    public function index()
    {
        $vendor = Vendor::where('user_id', auth()->id())->firstOrFail();

        $orders = $vendor->orders()
            ->where('status_pembayaran', 'lunas')
            ->with(['guestUser', 'orderDetails.menu'])
            ->latest()
            ->get();

        return view('vendor.orders.index', compact('orders', 'vendor'));
    }
}
