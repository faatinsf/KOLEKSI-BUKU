<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{

    public function ajaxIndex()
    {
        return view('ajax-axios.case2-ajax');
    }

    public function axiosIndex()
    {
        return view('ajax-axios.case2-axios');
    }

    public function getBarang($kode)
    {
        $barang = DB::table('barang')
            ->where('id_barang',$kode)
            ->first();

        return response()->json($barang);
    }

    public function simpanTransaksi(Request $request)
    {

        DB::beginTransaction();

        try{

            // simpan ke tabel penjualan
            $id_penjualan = DB::table('penjualan')->insertGetId([
                'total'=>$request->total
            ], 'id_penjualan'); // penting karena primary key bukan "id"

            foreach($request->items as $item){

                DB::table('penjualan_detail')->insert([
                    'id_penjualan'=>$id_penjualan,
                    'id_barang'=>$item['kode'],
                    'jumlah'=>$item['jumlah'],
                    'subtotal'=>$item['subtotal']
                ]);

            }

            DB::commit();

            return response()->json([
                'status'=>true
            ]);

        }catch(\Exception $e){

            DB::rollback();

            return response()->json([
                'status'=>false,
                'error'=>$e->getMessage()
            ]);

        }

    }

}