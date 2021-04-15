<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AndroidController extends Controller
{
    function coba(){
        $menu = Menu::where('id_kategori', '1')->get();
        dd(count($menu));
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
}
