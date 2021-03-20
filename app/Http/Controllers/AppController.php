<?php

namespace App\Http\Controllers;

use App\Models\PasswordAplikasi;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function settingView(){
        return view('admin.setting');
    }

    public function settingSubmit(Request $request){
        $customMessages = [
            'newpass.regex'         => 'Password minimal terdiri dari 5 karakter dan mengandung minimal 1 angka',
            'newpassconfirm.regex'  => 'Password minimal terdiri dari 5 karakter dan mengandung minimal 1 angka',
            'newpassconfirm.same'   => 'Isi konfirmasi password tidak sesuai'
        ];

        $input = $request->validate([
            'oldpass'           => 'required|alpha_num',
            'newpass'           => 'required|alpha_num|regex:/^(?=.*\d).{5,}$/',
            'newpassconfirm'    => 'required|alpha_num|same:newpass',
        ], $customMessages);

        $oldpass = PasswordAplikasi::orderBy('id', 'DESC')->first();
        if ($oldpass->password != $input['oldpass']) {
            return redirect()->back()
                ->with('error', 'Password lama salah');
        }
        else{
            $newpass = new PasswordAplikasi();
            $newpass->id_admin = $request->session()->get('id_aktif');
            $newpass->password = $input['newpass'];
            $result = $newpass->save();

            if ($result) {
                return redirect()->back()
                    ->with('success', 'Berhasil mengganti password aplikasi');
            }
        }
    }
}
