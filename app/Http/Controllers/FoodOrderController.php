<?php

namespace App\Http\Controllers;

use App\Http\Resources\PesananListResources;
use App\Http\Resources\PesananRekapMenuResources;
use App\Models\DetailOrder;
use App\Models\HeaderOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use stdClass;

class FoodOrderController extends Controller
{
    public function list($status){
        $title = '';

        //cek status
        if ($status == 'ongoing') {
            $title = 'Daftar Pesanan Yang Perlu Disiapkan';
        }
        else if ($status == 'all') {
            $title = 'Daftar Semua Pesanan Pelanggan';
        }
        else{
            return redirect()->route('foodorder.list', ['status' => 'ongoing'])
                ->with('error', 'Status pesanan menu tidak dikenali');
        }

        // //pass data header yang sedang makan
        // $dataHeaderAll = HeaderOrder::orderBy('created_at', 'ASC')
        //     ->where('status_order', '=', 1)
        //     ->with('details')
        //     ->get();

        // //empty eloquent collection dari HeaderOrder
        // $dataHeaderPerluDisiapkan = collect(new HeaderOrder());

        // foreach ($dataHeaderAll as $key => $header) {
        //     $tmpDetails = $header->details()->where('status_diproses', '=', 1)->get();
        //     if (count($tmpDetails) > 0) {
        //         $dataHeaderPerluDisiapkan->add($header);
        //     }
        // }

        // //display
        // $dataHeader = collect(new HeaderOrder());
        // if ($status == "ongoing") {
        //     $dataHeader = $dataHeaderPerluDisiapkan;
        // }
        // else{
        //     $dataHeader = $dataHeaderAll;
        // }

        // //mendapatkan semua details dari h_order
        // $dataDetails = $dataHeader->pluck('details')->flatten();
        // //mendapatkan semua menu dari details yang masih belum selesai disiapkan (status order = 1)
        // $dataMenuPesanan = $dataDetails->pluck('menu')->flatten()->unique();
        // foreach ($dataMenuPesanan as $key => $menu) {
        //     $menu->jumlah = $dataDetails
        //         ->where('id_menu', '=', $menu->id)
        //         ->where('status_diproses', '=', 1)
        //         ->sum('jumlah');
        // }

        // dd($dataMenuPesanan);
        return view('food_order.list', [
            // 'dataPesanan'       => $dataHeader,
            // 'dataMenuPesanan'   => $dataMenuPesanan,
            'title'             => $title,
            'status'            => $status,
        ]);
    }

    public function getRekapanMenuPesananJson($status){
        //pass data header yang sedang makan
        $dataHeaderAll = HeaderOrder::orderBy('created_at', 'ASC')
            ->where('status_order', '=', 1)
            ->with('details')
            ->get();

        //empty eloquent collection dari HeaderOrder
        $dataHeaderPerluDisiapkan = collect(new HeaderOrder());

        foreach ($dataHeaderAll as $key => $header) {
            $tmpDetails = $header->details()->where('status_diproses', '=', 1)->get();
            if (count($tmpDetails) > 0) {
                $dataHeaderPerluDisiapkan->add($header);
            }
        }

        //display
        $dataHeader = collect(new HeaderOrder());
        if ($status == "ongoing") {
            $dataHeader = $dataHeaderPerluDisiapkan;
        }
        else{
            $dataHeader = $dataHeaderAll;
        }

        //mendapatkan semua details dari h_order
        $dataDetails = $dataHeader->pluck('details')->flatten();
        //mendapatkan semua menu dari details yang masih belum selesai disiapkan (status order = 1)
        $dataMenuPesanan = $dataDetails->pluck('menu')->flatten()->unique();
        foreach ($dataMenuPesanan as $key => $menu) {
            $menu->jumlah = $dataDetails
                ->where('id_menu', '=', $menu->id)
                ->where('status_diproses', '=', 1)
                ->sum('jumlah');
        }

        return PesananRekapMenuResources::collection(collect($dataMenuPesanan)->where('jumlah', '>', 0));
    }

    public function getDataPesananJson($status){
        //pass data header yang sedang makan
        $dataHeaderAll = HeaderOrder::orderBy('created_at', 'ASC')
            ->where('status_order', '=', 1)
            ->with('details')
            ->get();

        //empty eloquent collection dari HeaderOrder
        $dataHeaderPerluDisiapkan = collect(new HeaderOrder());

        foreach ($dataHeaderAll as $key => $header) {
            $tmpDetails = $header->details()->where('status_diproses', '=', 1)->get();
            if (count($tmpDetails) > 0) {
                $dataHeaderPerluDisiapkan->add($header);
            }
        }

        //display
        $dataHeader = collect(new HeaderOrder());
        if ($status == "ongoing") {
            $dataHeader = $dataHeaderPerluDisiapkan;
        }
        else{
            $dataHeader = $dataHeaderAll;
        }

        return PesananListResources::collection($dataHeader);
    }

    public function foodPrepared($idDetailOrder){
        $detail = DetailOrder::find($idDetailOrder);

        if ($detail == null) {
            return redirect()->back()
                ->with('error', 'Data pesanan menu tidak ditemukan');
        }
        else{
            $detail->id_koki = session('id_aktif');
            $detail->status_diproses = 2;
            $result = $detail->save();

            if ($result) {
                return redirect()->back()
                    ->with('success', 'Berhasil mengganti status pesanan menu Meja '.
                        $detail->header->nomor_meja . ' - ' . $detail->menu->nama);
            }
            else{
                return redirect()->back()
                    ->with('error', 'Gagal mengganti status pesanan menu');
            }
        }
    }

    public function foodPreparedAll($idHeaderOrder){
        $header = HeaderOrder::find($idHeaderOrder);
        $result = true;
        $errMsg = '';

        if ($header == null) {
            return redirect()->back()
                ->with('error', 'Data pesanan menu tidak ditemukan');
        }
        else{
            // dd($header->details);

            //try catch untuk transaction
            try {
                DB::beginTransaction();
                foreach ($header->details as $key => $detail) {
                    $detail->id_koki = session('id_aktif');
                    $detail->status_diproses = 2;
                    $result = $result && $detail->save();
                }
                DB::commit();
            } catch (\Exception $e) {
                $errMsg = $e->getMessage();
                DB::rollBack();
            }

        }

        if ($result) {
            return redirect()->back()
                ->with('success', 'Berhasil mengganti status semua pesanan menu MEJA '.
                    $header->nomor_meja . ' menjadi sudah selesai disiapkan');
        }
        else{
            return redirect()->back()
                ->with('error', 'Gagal mengganti status pesanan menu : ' . $errMsg);
        }
    }
}
