<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function __construct()
    {
      \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
      \Midtrans\Config::$clientKey    = env('MIDTRANS_CLIENT_KEY');
      \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
      \Midtrans\Config::$isSanitized  = env('MIDTRANS_IS_SANITIZED');
      \Midtrans\Config::$is3ds        = env('MIDTRANS_IS_3DS');
    }
    public function select_pay($id){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
      $order = Transaction::find($id)->first();
      return view('transaction.payment',[
        'order'=>$order,'cartCount'=>$cartCount,'type'=>'create'
      ]);
    }
    public function post_pay($id,$type){
        if(!auth()->check()){
            $cartCount = 0;
            return redirect()->to(route('auth.login'));
        }else{
            $cartCount = Cart::where('user_id',auth()->user()->id)->count();
            if($cartCount == null){
                $cartCount = 0;
            }
        }
      if($type=='cek'){
        $payment=Payment::where('id',$id)->first();
        $snapToken = $payment->merchant_id;
        $order = Order::find($payment->order_id)->first();
        $midtransId = 'TRA'.$order->id.'-'.time();
        return view('pages.snap',[
          'clientKey'=>\Midtrans\Config::$clientKey,
          'snap_token'=>$snapToken,'direct'=>false,'pageConfigs'=> $pageConfigs,'profile'=>$about,'footerTitles'=>$footerTitles, 'sisa'=>0, 'order'=>$order,'payment'=>$payment
        ]);
      }else{
        $order = Transaction::find($id)->first();
        $midtransId = 'TRX-'.time();
        $item_details = [];
        foreach($order->transactionDetail as $detail){
            $item_details[] = [
                'id'       => $detail->id,
                'price'    => $detail->price,
                'quantity' => $detail->qty,
                'name'     => $detail->product->nama,
            ];
        }
        $item_details[] = [
            'id'       => $order->service->id,
            'price'    => $order->service->value,
            'quantity' => 1,
            'name'     => $order->service->servis,
        ];
        $payload = [
            'transaction_details' => [
                'order_id'     => $midtransId,
                'gross_amount' => (string) $order->total,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
            ],
            'item_details' => $item_details,
        ];
        try {
        $snapToken = \Midtrans\Snap::getSnapToken($payload);
        }
        catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
        $midtrans_order_id = $snapToken;
        $order->midtrans_order_id = $midtrans_order_id;
        $order->save();
        //hapus cart
        $cart = Cart::where('user_id', auth()->user()->id)->where('is_selected',1)->delete();
        return view('transaction.snap',[
            'clientKey'=>\Midtrans\Config::$clientKey,
            'snap_token'=>$snapToken,'order'=>$order,'cartCount'=>$cartCount
        ]);
      }
    }
    public function update($id,$status){
      $payment = Transaction::find($id);
        if($status=="success"){
          $status = "menunggu konfirmasi";
          $payment->status = $status;
          $payment->save();
          return redirect(route('user.transaction'))->with('success', 'Berhasil melakukan pembayaran');
        }else{
            $status = "pembayaran gagal";
            $payment->status = $status;
            $payment->save();
            return redirect(route('user.transaction'))->with('error', 'Pembayaran gagal');
        }
    }
    public function handleNotification()
    {
      $client = new Client();
      $serverKey = \Midtrans\Config::$serverKey;
      $auth = base64_encode($serverKey . ':');
      $payment = Transaction::where('status','menunggu pembayaran');
      foreach($payment as $pay){
        $response = $client->request('GET', 'https://api.sandbox.midtrans.com/v2/' . $pay->midtrans_order_id . '/status', [
          'headers' => [
              'Authorization' => 'Basic ' . $auth,
              'Accept' => 'application/json',
          ],
        ]);

      $body = $response->getBody();
      $content = $body->getContents();
      $data = json_decode($body,true);
        $transaction_status = $data['transaction_status'];
        $order_id = $data['order_id'];
        $payment_type = $data['payment_type'];

        switch ($transaction_status) {
            case 'capture':
                // TODO: set payment status in merchant's database to 'Success'
                echo "Transaction order_id: " . $order_id ." successfully captured using " . $payment_type;
                  $order = Transaction::where('midtrans_order_id', '=', $order_id)->first();
                  $order->status = "menunggu konfirmasi";
                  $order->save();
                break;
            case 'settlement':
                // TODO: set payment status in merchant's database to 'Settlement'
                echo "Transaction order_id: " . $order_id ." successfully transfered using " . $payment_type;
                $order = Transaction::where('midtrans_order_id', '=', $order_id)->first();
                $order->status = "menunggu konfirmasi";
                $order->save();
                break;
            case 'pending':
                // TODO: set payment status in merchant's database to 'Pending'
                echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $payment_type;
                break;
            case 'deny':
                // TODO: set payment status in merchant's database to 'Denied'
                echo "Payment using " . $payment_type . " for transaction order_id: " . $order_id . " is denied.";
                //delete payment
                $pay->status="pembayaran gagal";
                $pay->save();
                break;
            case 'expire':
                // TODO: set payment status in merchant's database to 'expire'
                echo "Payment using " . $payment_type . " for transaction order_id: " . $order_id . " is expired.";
                $pay->status="pembayaran gagal";
                $pay->save();
                break;
            case 'cancel':
                // TODO: set payment status in merchant's database to 'Denied'
                echo "Payment using " . $payment_type . " for transaction order_id: " . $order_id . " is canceled.";
                $pay->status="pembayaran gagal";
                $pay->save();
                break;
        }
      }
    }
    function printExampleWarningMessage() {
        if (strpos(\Midtrans\Config::$serverKey, 'your ') != false ) {
            echo "<code>";
            echo "<h4>Please set your server key from sandbox</h4>";
            echo "In file: " . __FILE__;
            echo "<br>";
            echo "<br>";
            echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
            die();
        }
    }
    public function buat_pesanan(Request $request)
    {
        if($request->user()->role != 'user'){
            return redirect()->route('public.index');
        }
        $user = auth()->user();
        if($request->tipe =='single'){
            $transaction_code =  'TRX-'.time();
            $ongkir = $request->ongkir;
            $servis = $request->service;
            $produk_id = $request->product_id;
            $jumlah = 1;
            $nama = $request->kurir;

            $total = $request->total;
            $pesanan = Transaction::create([
                'transaction_code' => $transaction_code,
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'menunggu pembayaran',
                'midtrans_order_id' => '0',
            ]);
            if($pesanan){
                $produk  = Product::find($produk_id);
                $produk->stok = $produk->stok - $jumlah;
                $produk->save();
                $harga = $produk->harga;
                $total = $harga * $jumlah;
                TransactionDetail::create([
                    'transaction_id' => $pesanan->id,
                    'product_id' => $produk_id,
                    'qty' => $jumlah,
                    'price' => $harga,
                    'total' => $total,
                ]);
                $kode = '';
                $servis = $servis;
                $nama = $nama;
                $deskripsi = '';
                $value = $ongkir;
                $note = $user->name.' - '.$user->phone.' - '.$user->address.' desa / kelurahan '.$user->kelurahan.' kecamatan '.$user->kecamatan.' kabupaten/kota '.$user->kota_name.' provinsi '.$user->provinsi_name;

                Service::create([
                    'transaction_id' => $pesanan->id,
                    'kode' => $kode,
                    'servis' => $servis,
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'value' => $value,
                    'note' => $note,
                ]);
            }
        }else{
            $keranjang = Cart::where('user_id', $user->id)->where('is_selected', 1)->get();
            $total = 0;
            $transaction_code =  'TRX-'.time();
            $ongkir = $request->ongkir;
            $servis = $request->service;
            $jumlah = $keranjang->count();
            $nama = $request->kurir;

            $total = $request->total;
            $pesanan = Transaction::create([
                'transaction_code' => $transaction_code,
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'menunggu pembayaran',
                'midtrans_order_id' => '0',
            ]);
            if($pesanan){
                foreach($keranjang as $cart){
                    $produk_id = $cart->product_id;
                    $produk  = Product::find($produk_id);
                    $produk->stok = $produk->stok - $jumlah;
                    $produk->save();
                    $harga = $produk->harga;
                    $total = $harga * $jumlah;
                    TransactionDetail::create([
                        'transaction_id' => $pesanan->id,
                        'product_id' => $produk_id,
                        'qty' => $jumlah,
                        'price' => $harga,
                        'total' => $total,
                    ]);
                }
                $kode = '';
                $servis = $servis;
                $nama = $nama;
                $deskripsi = '';
                $value = $ongkir;
                $note = $user->name.' - '.$user->phone.' - '.$user->address.' desa / kelurahan '.$user->kelurahan.' kecamatan '.$user->kecamatan.' kabupaten/kota '.$user->kota_name.' provinsi '.$user->provinsi_name;

                Service::create([
                    'transaction_id' => $pesanan->id,
                    'kode' => $kode,
                    'servis' => $servis,
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'value' => $value,
                    'note' => $note,
                ]);
            }
        }

        return redirect()->route('buat-pembayaran', $pesanan->id);
    }

}
