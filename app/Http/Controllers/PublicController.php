<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Favorit;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(){
        session()->put('kembali', url()->previous());
        if(!auth()->check()){
            $cartCount = 0;
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        //ambil 6 peroduk terbaru
        $baru = Product::orderBy('created_at', 'DESC')->take(6)->get();
        $promosi = Product::where('isPromosi', 1)->first();
        return view('public/index',['baru' => $baru, 'promosi' => $promosi, 'cartCount'=>$cartCount]);
    }
    public function product(){
        session()->put('kembali', url()->previous());
        if(!auth()->check()){
            $cartCount = 0;
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        return view('public/product',['cartCount'=>$cartCount]);
    }
    public function product_detail($id){
        session()->put('kembali', url()->previous());
        if(!auth()->check()){
            $cartCount = 0;
            $favorit = null;
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
            $favorit = Favorit::where('user_id', auth()->user()->id)->where('product_id', $id)->first();
        }
        $produk = Product::with('productImage')->findOrFail($id);
        $produk_terkait = Product::where('category_id', $produk->category_id)->where('id', '!=', $produk->id)->take(6)->get();
        $review = $produk->rating()->get();

        return view('public/product_detail', ['produk' => $produk, 'produk_terkait' => $produk_terkait, 'review' => $review, 'cartCount'=>$cartCount, 'favorit' => $favorit]);
    }
    public function tambah_keranjang(Request $request){
        session()->put('kembali', url()->previous());
        if(!auth()->check()){
            return redirect()->route('filament.admin.auth.login')->with('error', 'Silahkan login terlebih dahulu');
        }
        $this->validate($request, [
            'product_id' => 'required',
        ]);
        $qty=1;
        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->first();
        if($cart){
            $cart->qty = $cart->qty + $qty;
            $cart->save();
        }else{
            Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $request->product_id,
                'qty' => $qty
            ]);
        }
        return redirect()->back()->with('success', 'Berhasil menambahkan produk ke keranjang');
    }
    public function tambah_favorit(Request $request){
        session()->put('kembali', url()->previous());
        if(!auth()->check()){
            return redirect()->route('filament.admin.auth.login')->with('error', 'Silahkan login terlebih dahulu');
        }
        $this->validate($request, [
            'product_id' => 'required',
        ]);
        $favorit = Favorit::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->first();
        if($favorit){
            $favorit->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus produk dari favorit');
        }
        Favorit::create([
            'user_id' => auth()->user()->id,
            'product_id' => $request->product_id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan produk ke favorit');
    }
    public function single_checkout(Request $request){
        session()->put('kembali', url()->previous());
        if(!auth()->check()){
            $cartCount = 0;
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        if(!auth()->check()){
            return redirect()->route('filament.admin.auth.login')->with('error', 'Silahkan login terlebih dahulu');
        }
        $this->validate($request, [
            'product_id' => 'required',
        ]);
        // $rajaOngkirController = new RajaOngkirController;
        // $jne = json_decode($rajaOngkirController->ongkir($request->product_id, 'single', 'jne'));
        // $jnt = json_decode($rajaOngkirController->ongkir($request->product_id, 'single', 'jnt'));
        $jne=json_decode('{"rajaongkir":{"query":{"origin":"501","destination":"114","weight":1700,"courier":"jne"},"status":{"code":200,"description":"OK"},"origin_details":{"city_id":"501","province_id":"5","province":"DI Yogyakarta","type":"Kota","city_name":"Yogyakarta","postal_code":"55111"},"destination_details":{"city_id":"114","province_id":"1","province":"Bali","type":"Kota","city_name":"Denpasar","postal_code":"80227"},"results":[{"code":"jne","name":"Jalur Nugraha Ekakurir (JNE)","costs":[{"service":"OKE","description":"Ongkos Kirim Ekonomis","cost":[{"value":54000,"etd":"4-5","note":""}]},{"service":"REG","description":"Layanan Reguler","cost":[{"value":62000,"etd":"2-3","note":""}]}]}]}}');
        $jnt = $jne;
        $customer =Customer::where('user_id', auth()->user()->id)->first();
        $produk = Product::findOrFail($request->product_id);
        return view('transaction.single_chekout', ['id' => $produk->id,'produk' => $produk, 'customer' => $customer, 'cartCount'=>$cartCount, 'jne' => $jne, 'jnt' => $jnt]);
    }
}
