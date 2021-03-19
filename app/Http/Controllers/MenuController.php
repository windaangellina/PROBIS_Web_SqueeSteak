<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function list(){
        $dataMenu = Menu::orderBy('nama')->get();

        return view('menu.list', [

            'datamenu' => $dataMenu
        ]);
    }

    public function viewAdd(){
        $dataKategori = Kategori::orderBy('id')->get();
        return view('menu.add', [
            'dataKategori'  => $dataKategori
        ]);
    }

    public function submitAdd(Request $request){
        $input = $request->validate([
            'picture'   => 'required',
            'nama'      => 'required|alpha',
            'kategori'  => 'required',
            'harga'     => 'required',
        ]);

        //new menu
        $menu = new Menu();
        $menu->id_kategori = $input['kategori'];
        $menu->id_admin = $request->session()->get('id_aktif');
        $menu->nama = $input['nama'];
        $menu->harga = $input['harga'];
    }
}
