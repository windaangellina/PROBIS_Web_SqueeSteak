<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\HeaderOrder;
use App\Models\Menu;
use App\Models\Kategori;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AndroidController extends Controller
{
    // function coba(){
    //     $menu = Menu::where('id_kategori', '1')->get();
    //     dd(count($menu));
    // }

    function coba(){
        $response = array();
        $hari = "INV" . date('Ymd');
        $order = HeaderOrder::where('kode_order', 'like', '%'.$hari.'%')->latest()->first();
        if($order->status_order != 3){
            $kode = $order->kode_order;
        }
        else{
            $substr = intval(substr($order->kode_order, -3)) + 1;
            $kode = $hari . str_pad($substr,5,"0",STR_PAD_LEFT);
            $new = new HeaderOrder();
            $new->kode_order = $kode;
            $new->nomor_meja = $request->meja;
            $new->status_order = 0;
            $new->save();
        }
        $response["code"] = 1;
        $response["message"] = $kode;
        echo json_encode($response);
    }

    function ubahNoMeja(Request $request){
        $response = array();
        if(isset($request->function) && isset($request->password)){
            $func = $request->function;
            if($func == "ubahNoMeja"){
                $password = $request->password;
                $db = DB::table('password_aplikasi')->latest()->first();
                if($db->password == $password){
                    $response["code"] = 1;
                    $response["message"] = "Password Benar";
                }
                else{
                    $response["code"] = -2;
                    $response["message"] = "Password Salah";
                }
            }
            else{
                $response["code"] = -1;
                $response["message"] = "Request Invalid";
            }
        }
        else{
            $response["code"] = -1;
            $response["message"] = "Request Invalid";
        }
        echo json_encode($response);
    }

    function getMenu(Request $request){
        if(isset($request->function) && isset($request->kategori)){
            $func = $request->function;
            $kategori = $request->kategori;
            $menu = Menu::where('id_kategori', $kategori)->get();
            if($func == "getMenu"){
                if(count($menu) > 0){
                    $data = array();
                    $arrMenu = array();
                    foreach($menu as $key => $value){
                        $data["id"] = $value["id"];
                        $c = Kategori::find($value["id_kategori"]);
                        $data["nama_kategori"] = $c->folder;
                        $data["nama"] = $value["nama"];
                        $data["harga"] = $value["harga"];
                        $data["url"] = $value["url_foto_menu"];
                        $data["deskripsi"] = $value["deskripsi"];
                        $arrMenu[$key] = $data;
                    }
                    $response["code"] = 1;
                    $response["message"] = "Get Data Successful";
                    $response["menu"] = $arrMenu;
                }
                else{
                    $response["code"] = -3;
                    $response["message"] = "No Data";
                }
            }
            else{
                $response["code"] = -1;
            $response["message"] = "Request Invalid";
            }
        }
        else{
            $response["code"] = -1;
            $response["message"] = "Request Invalid";
        }
        echo json_encode($response);
    }

    function makeHeader(Request $request){
        // $response = array();
        // $hari = "INV" . date('Ymd');
        // $jumlah = DB::table('h_order')->where('kode_order','like','%'.$hari.'%')->get()->count() + 1;
        // $kode = $hari . str_pad($jumlah,5,"0",STR_PAD_LEFT);
        // $response["code"] = 1;
        // if($jumlah == 1){
        //     $order = new HeaderOrder();
        //     $order->kode_order = $kode;
        //     $order->nomor_meja = $request->meja;
        //     $order->status_order = 0;
        //     $order->save();
        // }
        // else{
        //     $kode = $hari . str_pad($jumlah-1,5,"0",STR_PAD_LEFT);
        // }
        // $response["message"] = $kode;
        // echo json_encode($response);

        $response = array();
        $hari = "INV" . date('Ymd');
        $order = HeaderOrder::where('kode_order', 'like', '%'.$hari.'%')->latest()->first();
        $jumlah = DB::table('h_order')->where('kode_order','like','%'.$hari.'%')->get()->count() + 1;
        if($order != null){
            if($order->status_order != 3){
                $kode = $order->kode_order;
            }
            else{
                $substr = intval(substr($order->kode_order, -5)) + 1;
                $kode = $hari . str_pad($substr,5,"0",STR_PAD_LEFT);
                $new = new HeaderOrder();
                $new->kode_order = $kode;
                $new->nomor_meja = $request->meja;
                $new->status_order = 0;
                $new->save();
            }
        }
        else{
            $kode = $hari . str_pad($jumlah,5,"0",STR_PAD_LEFT);
            $new = new HeaderOrder();
            $new->kode_order = $kode;
            $new->nomor_meja = $request->meja;
            $new->status_order = 0;
            $new->save();
        }

        $response["code"] = 1;
        $response["message"] = $kode;
        echo json_encode($response);
    }

    function addItem(Request $request){
        $response = array();
        $idOrder = DB::table('h_order')->where('kode_order','=',$request->kode)->get();
        $order = new DetailOrder();
        $order->id_order = $idOrder['0']->id;
        $order->id_menu = $request->id;
        $order->status_diproses = 0;
        $order->harga = $request->harga;
        $order->jumlah = $request->jumlah;
        $order->subtotal = $request->subtotal;
        $order->keterangan = $request->keterangan;
        $order->save();
        DB::table('h_order')->where('kode_order','=',$request->kode)->update(['total' => $idOrder['0']->total + $request->subtotal]);
        $idOrder->save();
        $response["code"] = 1;
        $response["message"] = "Menu berhasil ditambahkan";
        echo json_encode($response);
    }

    function showList(Request $request){
        $response = array();
        $hOrder = DB::table('h_order')->where('kode_order','=',$request->kode)->get();
        $dOrder = DetailOrder::where('id_order',$hOrder['0']->id)->get();
        if($request->status != 2){
            $data = array();
            for ($i=0; $i < count($dOrder); $i++) {
                $menu = Menu::where('id',$dOrder[$i]->id_menu)->get();
                $data[$i]['nama'] = $menu[0]->nama;
                $data[$i]['jumlah'] = $dOrder[$i]->jumlah;
                $data[$i]['subtotal'] = $dOrder[$i]->subtotal;
            }
            $response["code"] = 1;
            $response["message"] = $data;
        }
        else{
            $result = DB::table('h_order')->where('kode_order','=',$request->kode)->update(['status_order' => '2']);
            if($result){
                $resultDetail = DB::table('d_order')->where('id_order',$hOrder['0']->id)->update(['status_diproses' => '2']);
                if($resultDetail){
                    $response["code"] = 1;
                    $response["message"] = "Perubahan Berhasil";
                }
                else{
                    $response["code"] = 2;
                    $response["message"] = "Perubahan Gagal";
                }
            }
        }
        echo json_encode($response);
    }

    function changeStatusPesanan(Request $request){
        $response = array();
        $hOrder = DB::table('h_order')->where('kode_order','=',$request->kode)->get();
        $result = DB::table('h_order')->where('kode_order','=',$request->kode)->update(['status_order' => '1']);
        if($result){
            $resultDetail = DB::table('d_order')->where('id_order',$hOrder['0']->id)->update(['status_diproses' => '1']);
            if($resultDetail){
                $dOrder = DetailOrder::where('id_order',$hOrder['0']->id)->get();
                $data = array();
                for ($i=0; $i < count($dOrder); $i++) {
                    $menu = Menu::where('id',$dOrder[$i]->id_menu)->get();
                    $data[$i]['nama'] = $menu[0]->nama;
                    $data[$i]['jumlah'] = $dOrder[$i]->jumlah;
                    $data[$i]['subtotal'] = $dOrder[$i]->subtotal;
                }
                $response["code"] = 1;
                $response["message"] = $data;
            }
            else{
                $response["code"] = 2;
                $response["message"] = "Perubahan Gagal";
            }
        }
        echo json_encode($response);
    }
}
