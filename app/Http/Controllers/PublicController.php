<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){
        return view('public/index');
    }
    public function product(){
        return view('public/product');
    }
    public function product_detail(){
        return view('public/product_detail');
    }
}
