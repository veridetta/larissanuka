<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        //cek user login
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        return view('user/user',['cartCount'=>$cartCount]);
    }
}
