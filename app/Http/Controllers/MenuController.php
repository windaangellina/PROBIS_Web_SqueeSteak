<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuListResources;
use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function list(){
        //$dataMenu = Menu::withTrashed()->orderBy('updated_at', 'DESC')->get();
        // return view('menu.list-basic', [
        //     'datamenu' => $dataMenu
        // ]);

        //ajax
        return view('menu.list');
    }

    public function getListJson(){
        $dataMenu = Menu::withTrashed()->orderBy('updated_at', 'DESC')->get();
        return MenuListResources::collection($dataMenu);
    }

    public function viewAdd(){
        $dataKategori = Kategori::orderBy('id')->get();
        return view('menu.add', [
            'dataKategori'  => $dataKategori
        ]);
    }

    public function submitAdd(Request $request){
        $customMessages = [
            'picture.max'   => 'ukuran foto menu max 10 mb',
            'picture.mimes' => 'foto harus dalam format jpeg,jpg,png,bmp atau tiff',
        ];

        $input = $request->validate([
            'picture'   => 'mimes:jpeg,jpg,png,bmp,tiff |max:4096',
            'nama'      => 'required',
            'kategori'  => 'required',
            'harga'     => 'required',
        ], $customMessages);

        //cek apakah menu dengan nama yang sama sudah ada
        $cekmenu = Menu::where('nama', '=', $input['nama'])->get();
        if ($cekmenu != null && count($cekmenu) > 0) {
            return redirect()->back()
                ->with('error', 'nama menu sudah terdaftar');
        }
        else{
            //new menu
            $menu = new Menu();
            $menu->id_kategori = $input['kategori'];
            $menu->id_admin = $request->session()->get('id_aktif');
            $menu->nama = $input['nama'];
            $menu->harga = $input['harga'];

            //cek apakah deskripsi ada diisi
            if ($request->input('deskripsi') != null) {
                $menu->deskripsi = $request->input('deskripsi');
            }

            //simpan
            $result = $menu->save();

            //file upload : gambar menu
            if ($request->file('picture') != null) {
                $namafile = $menu->kategori->folder . '-' . Str::slug($menu->nama);
                $namafileWithExtension = $namafile . "." . $request->file('picture')->getClientOriginalExtension();

                //cek apakah nama file sudah ada (mencegah replace kl slug ny sama)
                $ceknamafilemenu = Menu::where('url_foto_menu', '=', $namafileWithExtension)->get();
                if ($ceknamafilemenu != null && count($ceknamafilemenu) > 0) {
                    $ctr = count($ceknamafilemenu) + 1;
                    $namafileWithExtension = $namafile . '-' . $ctr .
                            "." . $request->file('picture')->getClientOriginalExtension();
                }

                //simpan di storage folder laravel
                $result == $result && $request->file('picture')
                    ->storeAs('res/'. $menu->kategori->folder, $namafileWithExtension, 'public');

                //update db
                $menu->url_foto_menu = $namafileWithExtension;
                $result = $result && $menu->save();
            }

            if ($result) {
                return redirect()->back()
                    ->with('success', 'Berhasil menambah menu ' . $menu->nama);
            }
            else{
                return redirect()->back()
                    ->with('error', 'Gagal menambah menu baru');
            }
        }


    }

    public function viewEdit($idMenu){
        $dataMenu = Menu::withTrashed()->where('id', '=', $idMenu)->first();

        if ($dataMenu != null) {
            $dataKategori = Kategori::orderBy('id')->get();
            return view('menu.edit', [
                'dataMenu'      => $dataMenu,
                'dataKategori'  => $dataKategori
            ]);
        }
        else{
            return redirect()->route('menu.list')
                ->with('error', 'Data menu tidak ditemukan');
        }

    }

    public function submitEdit($idMenu, Request $request){
        $customMessages = [
            'picture.max'   => 'Ukuran foto menu max 10 mb',
            'picture.mimes' => 'Foto harus dalam format jpeg,jpg,png,bmp atau tiff',
        ];

        $input = $request->validate([
            'picture'   => 'mimes:jpeg,jpg,png,bmp,tiff |max:4096',
            'nama'      => 'required',
            'harga'     => 'required',
        ], $customMessages);

        //edit menu
        $menu = Menu::withTrashed()->where('id', '=', $idMenu)->first();
        $menu->id_admin = $request->session()->get('id_aktif');
        $menu->nama = $input['nama'];
        $menu->harga = $input['harga'];

        //cek apakah deskripsi ada diisi
        $menu->deskripsi = $request->input('deskripsi');
        // if ($request->input('deskripsi') != null) {
        //     $menu->deskripsi = $request->input('deskripsi');
        // }

        //simpan
        $result = $menu->save();

        //file upload : gambar menu
        if ($request->file('picture') != null) {
            $namafile = $menu->kategori->folder . '-' . Str::slug($menu->nama);
            $namafileWithExtension = $namafile . "." . $request->file('picture')->getClientOriginalExtension();

            //simpan di storage folder laravel
            $result == $result && $request->file('picture')
                ->storeAs('res/'. $menu->kategori->folder, $namafileWithExtension, 'public');

            //update db
            $menu->url_foto_menu = $namafileWithExtension;
            $result = $result && $menu->save();
        }

        if ($result) {
            return redirect()->route('menu.list')
                ->with('success', 'Berhasil mengganti data menu ' . $menu->nama);
        }
        else{
            return redirect()->back()
                ->with('error', 'Gagal mengganti data menu');
        }
    }

    public function delete($idMenu){
        $dataMenu = Menu::find($idMenu);

        if ($dataMenu != null) {
            $dataMenu->delete();
            return redirect()->route('menu.list')
                ->with('error', 'Berhasil menghapus menu ' . $dataMenu->nama);
        }
        else{
            return redirect()->route('menu.list')
                ->with('error', 'Data menu tidak ditemukan');
        }
    }

    public function restore($idMenu){
        $dataMenu = Menu::withTrashed()->where('id', '=', $idMenu)->first();

        if ($dataMenu != null) {
            $dataMenu->restore();
            return redirect()->route('menu.list')
                ->with('success', 'Berhasil restorasi menu ' . $dataMenu->nama);
        }
        else{
            return redirect()->route('menu.list')
                ->with('error', 'Data menu tidak ditemukan');
        }
    }
}
