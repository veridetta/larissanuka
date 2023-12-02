<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(){
        return view('auth/login');
    }
    public function register(){
        return view('auth/register');
    }
    public function logout(){
        //hapus
        Auth::logout();
        return redirect()->route('public.index');
    }
    public function register_post(Request $request){
        if($request->password != $request->password_confirmation){
            return redirect()->back()->with('error','Password dan Konfirmasi Password tidak sama');
        }
        //cek email duplicate
        $cek_email = \App\Models\User::where('email',$request->email)->first();
        if($cek_email){
            return redirect()->back()->with('error','Email sudah terdaftar');
        }
        //insert data
        $user = new \App\Models\User;
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->role = 'user';
        $user->password = bcrypt($request->password);
        $user->save();
        if($user){
            $provinsi = explode('-',$request->provinsi);
            $kota = explode('-',$request->kota);
            $customer = new \App\Models\Customer;
            $customer->user_id = $user->id;
            $customer->nama = $request->nama;
            $customer->jenis_kelamin = $request->jenis_kelamin;
            $customer->alamat = $request->alamat;
            $customer->no_telp = $request->no_telp;
            $customer->provinsi_id = $provinsi[0];
            $customer->provinsi_name = $provinsi[1];
            $customer->kota_id = $kota[0];
            $customer->kota_name = $kota[1];
            $customer->kecamatan = $request->kecamatan;
            $customer->kelurahan = $request->kelurahan;
            $customer->kodepos = $request->kodepos;
            $customer->save();
            if($customer){
                return redirect()->route('auth.login')->with('success','Registrasi Berhasil');
            }else{
                return redirect()->back()->with('error','Registrasi Gagal');
            }
        }else{
            return redirect()->back()->with('error','Registrasi Gagal');
        }
    }

}
