<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function viewLogin(){
        return view('login');
    }

    public function submitLogin(Request $request){
        $input = $request->validate([
            "username" => "required",
            "pass" => "required"
        ]);

        $pegawai = Pegawai::where('username', '=', $input['username'])->first();
        if ($pegawai == null) {
            return redirect()->back()
                ->with('error', 'username tidak terdaftar');
        }
        else{
            if (\password_verify($input['pass'], $pegawai->password)) {
                $request->session()->put('id_aktif', $pegawai->id);
                $request->session()->put('username_aktif', $pegawai->username);
                $request->session()->put('role_aktif', $pegawai->role);

                return redirect()->route('home');
            }
            else{
                return redirect()->back()
                    ->with('error', 'password salah');
            }
        }
    }

    public function logout(Request $request){
        // reset session
        $request->session()->forget('id_aktif');
        $request->session()->forget('username_aktif');
        $request->session()->forget('role_aktif');

        return redirect()->route('login');
    }

    public function redirectLogin(Request $request){
        if ($request->session()->has('id_aktif') &&
            $request->session()->has('username_aktif') &&
            $request->session()->has('role_aktif')) {

            //cek role user
            $role = $request->session()->get('role_aktif');

            if ($role == 1) {
                //admin
                return redirect()->route('admin.home');
            }
            else if ($role == 2) {
                //kasir
                return redirect()->route('custorder.list', ['status' => 'done']);
            }
            else if ($role == 3) {
                //koki
                return redirect()->route('foodorder.list', ['status' => 'ongoing']);
            }
        }
        else{
            return redirect()->route('login');
        }
    }
}
