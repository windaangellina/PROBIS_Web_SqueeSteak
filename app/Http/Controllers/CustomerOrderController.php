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
                ->with('error', 'Status pesanan pelanggan tidak dikenali');
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

    public function detail($id){
        $pesanan = HeaderOrder::find($id);

        if ($pesanan == null) {
            return redirect()->back()
                ->with('error', 'Data pesanan pelanggan tidak ditemukan');
        }
        else{
            $status = 'pending';
            if ($pesanan->status_order == 1) {
                $status = 'ongoing';
            }
            else if ($pesanan->status_order == 2) {
                $status = 'done';
            }
            else if ($pesanan->status_order == 3) {
                $status = 'closed';
            }

            return view('customer_order.detail', [
                'status'        => $status,
                'dataPesanan'   => $pesanan
            ]);
        }
    }

    public function confirmPayment(Request $request, $id){
        $pesanan = HeaderOrder::find($id);

        if ($pesanan == null) {
            return redirect()->back()
                ->with('error', 'Data pesanan pelanggan tidak ditemukan');
        }
        else{
            if ($pesanan->status_order == 2) {
                $pesanan->status_order = 3;
                $pesanan->id_kasir = $request->session()->get('id_aktif');
                $result = $pesanan->save();

                if ($result) {
                    return redirect()->back()
                        ->with('success', 'Berhasil konfirmasi pembayaran untuk meja ' . $pesanan->nomor_meja .
                            ' / ' . $pesanan->kode_order);
                }
                else{
                    return redirect()->back()
                        ->with('success', 'Gagal konfirmasi pembayaran untuk meja ' . $pesanan->nomor_meja .
                            ' / ' . $pesanan->kode_order);
                }
            }
            else{
                if ($pesanan->status_order == 0) {
                    $errMessage = "Gagal Konfirmasi : Tidak ada pesanan makanan/minuman yang di-check out";
                }
                else if ($pesanan->status_order == 1) {
                    $errMessage = "Gagal Konfirmasi : Pelanggan belum konfirmasi sudah menyelesaikan pesanan";
                }
                else if ($pesanan->status_order == 3) {
                    $errMessage = "Gagal Konfirmasi : Pesanan sudah dibayar";
                }

                return redirect()->back()
                    ->with('error', $errMessage);
            }
        }
    }

}
