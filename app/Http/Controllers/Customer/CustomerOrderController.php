<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\GuestUser;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    /**
     * Halaman pemesanan: pilih vendor → menu tampil
     */
    public function index()
    {
        $vendors = Vendor::with('menus')->get();

        return view('customer.order', compact('vendors'));
    }

    /**
     * API: ambil menu berdasarkan vendor (untuk select berjenjang via AJAX)
     */
    public function getMenuByVendor($vendorId)
    {
        $menus = Menu::where('vendor_id', $vendorId)->get(['id', 'nama_menu', 'harga']);

        return response()->json($menus);
    }

    /**
     * Proses checkout: buat guest, order, order_detail, lalu minta snap token Midtrans
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'items'     => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.jumlah'  => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // 1. Buat guest user otomatis
            $guest = GuestUser::buatGuest();

            // 2. Hitung total
            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $menu     = Menu::findOrFail($item['menu_id']);
                $subtotal = $menu->harga * $item['jumlah'];
                $total   += $subtotal;

                $itemsData[] = [
                    'menu'     => $menu,
                    'jumlah'   => $item['jumlah'],
                    'subtotal' => $subtotal,
                ];
            }

            // 3. Buat order
            $order = Order::create([
                'guest_user_id'     => $guest->id,
                'vendor_id'         => $request->vendor_id,
                'total'             => $total,
                'status_pembayaran' => 'pending',
            ]);

            // 4. Buat order details
            foreach ($itemsData as $item) {
                OrderDetail::create([
                    'order_id'  => $order->id,
                    'menu_id'   => $item['menu']->id,
                    'jumlah'    => $item['jumlah'],
                    'subtotal'  => $item['subtotal'],
                ]);
            }

            // 5. Buat Snap Token Midtrans
            \Midtrans\Config::$serverKey    = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            $itemDetails = [];
            foreach ($itemsData as $item) {
                $itemDetails[] = [
                    'id'       => $item['menu']->id,
                    'price'    => $item['menu']->harga,
                    'quantity' => $item['jumlah'],
                    'name'     => $item['menu']->nama_menu,
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id'      => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount'  => $total,
                ],
                'customer_details' => [
                    'first_name' => $guest->nama_guest,
                ],
                'item_details' => $itemDetails,
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // 6. Simpan payment record
            Payment::create([
                'order_id'   => $order->id,
                'snap_token' => $snapToken,
                'status'     => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'snap_token'  => $snapToken,
                'order_id'    => $order->id,
                'guest_name'  => $guest->nama_guest,
                'client_key'  => config('midtrans.client_key'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Halaman sukses setelah bayar
     */
public function sukses($orderId)
{
    $order = Order::with(['orderDetails.menu', 'vendor', 'guestUser'])->findOrFail($orderId);

    // Endroid QR Code v6.x
    $qrCode = new \Endroid\QrCode\QrCode(data: (string) $order->id);
    $writer = new \Endroid\QrCode\Writer\PngWriter();
    $result = $writer->write($qrCode);

    $qrImage = 'data:image/png;base64,' . base64_encode($result->getString());

    return view('customer.sukses', compact('order', 'qrImage'));
}
}
