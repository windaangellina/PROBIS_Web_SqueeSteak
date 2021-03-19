<?php

namespace App\Http\Controllers;

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
}
