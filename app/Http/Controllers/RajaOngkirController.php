<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{
    //
    public function provinsi(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: ab07bf741e171eef8230086917eff06a"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {

            return response()->json(["error" => "cURL Error #:" . $err]);
        } else {
            $data = json_decode($response, true);

            // Ubah struktur data
            $results = [];
            foreach ($data['rajaongkir']['results'] as $province) {
                $results[] = [
                    "id" => (int)$province["province_id"]."-".$province["province"],
                    "text" => $province["province"]
                ];
            }

            // Buat struktur data yang diinginkan
            $newFormat = [
                "status" => 'success',
                "message" => "Data provinsi berhasil ditampilkan",
                "results" => $results,
                "pagination" => [
                    "more" => false
                ]
            ];

            // Ubah kembali ke JSON
            $newJson = json_encode($newFormat);
            return response()->json($newFormat);
        }
    }

    public function kota($id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: ab07bf741e171eef8230086917eff06a"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return response()->json(["error" => "cURL Error #:" . $err]);
        } else {
            $data = json_decode($response, true);
            // Ubah struktur data
            $results = [];
            foreach ($data['rajaongkir']['results'] as $city) {
                $results[] = [
                    "id" => $city["city_id"]."-".$city["city_name"],
                    "text" => $city["type"]." ".$city["city_name"]
                ];
            }
            // Buat struktur data yang diinginkan
            $newFormat = [
                "status" => 'success',
                "message" => "Data kota berhasil ditampilkan",
                "results" => $results,
                "pagination" => [
                    "more" => false
                ]
            ];
            // Ubah kembali ke JSON
            $newJson = json_encode($newFormat);
            return response()->json($newFormat);
        }
    }
    public static function ongkir($produkId,$jenis,$kurir){
        if($jenis=='single'){
            $produk = Product::findOrFail($produkId);
            $berat = $produk->dimension->berat;
            $customer = Customer::where('user_id', auth()->user()->id)->first();
            $destination = $customer->kota_id;
            $origin = 497;
        }else{
            $cart = Cart::where('user_id', auth()->user()->id)->get()->where('is_selected', 1);
            $berat = 0;
            foreach ($cart as $item) {
                $berat = $berat + $item->product->dimension->berat;
            }
            $customer = Customer::where('user_id', auth()->user()->id)->first();
            $destination = $customer->kota_id;
            $origin = 497;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$berat&courier=$kurir",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: ab07bf741e171eef8230086917eff06a"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return "cURL Error #:" . $err;
        } else {
        return $response;
        }
    }
}
