<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Favorit;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('filament.admin.auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        return view('user/user',['cartCount'=>$cartCount]);
    }
    public function profile(){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('filament.admin.auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        $user = User::where('id',auth()->user()->id)->first();
        return view('user/profile',['cartCount'=>$cartCount,'user'=>$user]);
    }
    public function profile_post(Request $request){
        $user = User::where('id',auth()->user()->id)->first();
        $user->name = $request->nama;
        $user->email = $request->email;
        if($request->password != null){
            if($request->password != $request->password_confirmation){
                return redirect()->back()->with('error','Password dan Konfirmasi Password tidak sama');
            }
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $customer = Customer::where('user_id',auth()->user()->id)->first();
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
        return redirect()->back()->with('success','Berhasil mengubah data');
    }
    public function favorit(){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('filament.admin.auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        $produk = Favorit::where('user_id',auth()->user()->id)->paginate(10);
        return view('user/favorit',['cartCount'=>$cartCount,'produk'=>$produk]);
    }
    public function favorit_cari(Request $request){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('filament.admin.auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        $produk = Favorit::where('user_id', auth()->user()->id)
            ->join('products', 'favorits.product_id', '=', 'products.id')
            ->where('products.nama', 'like', '%'.$request->search.'%')
            ->select('favorits.*') // select all columns from favorits table
            ->paginate(10);
        return view('user/favorit',['cartCount'=>$cartCount,'produk'=>$produk]);
    }
    public function rate(Request $request){
        $this->validate($request, [
            'product_id' => 'required',
            'rate' => 'required',
            'review' => 'required',
        ]);
        $rating = \App\Models\Rating::where('user_id',auth()->user()->id)->where('product_id',$request->product_id)->first();
        if($rating){
            $rating->rate = $request->rate;
            $rating->review = $request->review;
            $rating->save();
        }else{
            $rating = new \App\Models\Rating;
            $rating->user_id = auth()->user()->id;
            $rating->product_id = $request->product_id;
            $rating->rate = $request->rate;
            $rating->review = $request->review;
            $rating->save();
        }
        return redirect()->back()->with('success','Berhasil memberikan rating');
    }
    public function cart(){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('filament.admin.auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        $cart = Cart::where('user_id',auth()->user()->id)->get();
        return view('user/cart',['cartCount'=>$cartCount,'cart'=>$cart]);
    }
    public function cart_delete($id){
        $cart = Cart::where('id',$id)->first();
        $cart->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data'
        ]);
    }
    public function cart_update(Request $request, $id)
    {
        // Validate the request data

        // Find the cart item by id
        $cartItem = Cart::find($id);

        // If cart item not found, return an error response
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }
        if($request->qty != null){
            $cartItem->qty = $request->qty;
        }
        if($request->is_selected != null){
            $cartItem->is_selected = $request->is_selected;
            $value = 0;
            if($request->is_selected == true){
                $value = 1;
            }
            // Update the is_selected column
            $cartItem->is_selected = $value;
        }
        $cartItem->save();

        // Return a success response
        return response()->json(['success' => 'Cart item updated successfully.']);
    }
    public function transaction(){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('filament.admin.auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        $transaction = \App\Models\Transaction::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(10);
        return view('user/order',['cartCount'=>$cartCount,'transaction'=>$transaction]);
    }
    public function review($id){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('filament.admin.auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
        $transaction = \App\Models\Transaction::where('id',$id)->first();
        $transaction_detail = \App\Models\TransactionDetail::where('transaction_id',$id)->get();
        return view('user/rate',['transaction'=>$transaction,'transaction_detail'=>$transaction_detail,'cartCount'=>$cartCount]);
    }
    public function review_post(Request $request){
        $bintang = $request->rating;
        $review = $request->review;
        $product_id = $request->product_id;
        $user_id = auth()->user()->id;
        $rating = Rating::where('user_id',$user_id)->where('product_id',$product_id)->first();
        if($rating){
            $rating->rating = $request->rating;
            $rating->review = $request->review;
            $rating->save();
        }else{
            $rating = new Rating;
            $rating->user_id = $user_id;
            $rating->product_id = $product_id;
            $rating->rating = $request->rating;
            $rating->review = $request->review;
            $rating->save();
        }
        return redirect()->back()->with('success','Berhasil memberikan rating');
    }
}
