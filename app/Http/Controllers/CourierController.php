<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\City;

class CourierController extends Controller
{
  public function getProvince()
  {
    $response = Http::withHeaders([
      'key' => '45b6241fce218da567bf56d9130d9696'
    ])->get('https://api.rajaongkir.com/starter/province');
    return $response->body();
  }

  public function getCity()
  {
    $response = Http::withHeaders([
      'key' => '45b6241fce218da567bf56d9130d9696'
    ])->get('https://api.rajaongkir.com/starter/city');
    return $response->json();
  }

  public function getCost(Request $request)
  {
    $response = Http::withHeaders([
      'key' => '45b6241fce218da567bf56d9130d9696'
    ])->post('https://api.rajaongkir.com/starter/cost', [
      'origin' => $request->asal,
      'destination' => $request->tujuan,
      'weight' => $request->berat,
      'courier' => $request->kurir,
    ]);
    return $response->body();
  }

  public function postCity()
  {
    $hasil = Http::withHeaders([
      'key' => '45b6241fce218da567bf56d9130d9696'
    ])->get('https://api.rajaongkir.com/starter/city');
    $response = $hasil->json()->rajaongkir;
    // for ($i = 0; $i <= count($response); $i++) {
    //   $city = new City();
    //   $city->city_id = $response[$i]->city_id;
    //   $city->province = $response[$i]->province;
    //   $city->type = $response[$i]->type;
    //   $city->city_name = $response[$i]->city_name;
    //   $city->postal_code = $response[$i]->postal_code;
    //   $city->save();
    // };
    return $response;
  }
}
