<?php

namespace App\Http\Controllers;

use App\Models\HeaderOrder;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function list($status){
        $statusNumeric = 0;
        $deskripsi = ''; $title = '';

        //cek status
        if ($status == 'ongoing') {
            $statusNumeric = 1;
            $title = 'Daftar Pesanan Pelanggan : Sedang Berlangsung';
            $deskripsi = 'Daftar pesanan pelanggan yang sedang berlangsung (pelanggan sedang makan).';
        }
        else if ($status == 'done') {
            $statusNumeric = 2;
            $title = 'Daftar Pesanan Pelanggan : Sudah Konfirmasi Selesai Makan';
            $deskripsi = 'Daftar pesanan pelanggan yang sudah ditutup oleh pelanggan (pelanggan siap membayar).';
        }
        else if ($status == 'closed') {
            $statusNumeric = 3;
            $title = 'Daftar Pesanan Pelanggan : Sudah Dibayar';
            $deskripsi = 'Daftar pesanan pelanggan yang sudah lunas.';
        }
        else{
            return redirect()->route('custorder.list', ['status' => 'ongoing'])
                ->with('error', 'status pesanan pelanggan tidak dikenali');
        }

        //pass data
        $data = HeaderOrder::orderBy('created_at', 'ASC')
            ->where('status_order', '=', $statusNumeric)
            ->get();

        return view('customer_order.list', [
            'datapesananpelanggan'  => $data,
            'title'                 => $title,
            'deskripsi'             => $deskripsi,
            'status'                => $status
        ]);
    }



}
