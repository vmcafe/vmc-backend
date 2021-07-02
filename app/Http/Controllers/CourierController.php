<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use App\Models\Province;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CourierController extends Controller
{
  protected $API_KEY = '45b6241fce218da567bf56d9130d9696';
  public function getProvince()
  {
    $response = Http::withHeaders([
      'key' => $this->API_KEY
    ])->get('https://api.rajaongkir.com/starter/province');

    $provinces = $response['rajaongkir']['results'];

    return response()->json([
      'success' => true,
      'message' => 'Get All Provinces',
      'data'    => $provinces
    ]);
  }

  public function getCity()
  {
    $response = Http::withHeaders([
      'key' => $this->API_KEY
    ])->get('https://api.rajaongkir.com/starter/city');

    $cities = $response['rajaongkir']['results'];

    return response()->json([
      'success' => true,
      'message' => 'Get City : ',
      'data'    => $cities
    ]);
  }

  public function getCities($id)
  {
    $response = Http::withHeaders([
      'key' => $this->API_KEY
    ])->get('https://api.rajaongkir.com/starter/city?&province=' . $id . '');

    $cities = $response['rajaongkir']['results'];

    return response()->json([
      'success' => true,
      'message' => 'Get City By ID Provinces : ' . $id,
      'data'    => $cities
    ]);
  }

  public function getCost(Request $request)
  {
    $response = Http::withHeaders([
      'key' => $this->API_KEY
  ])->post('https://api.rajaongkir.com/starter/cost', [
      'origin'            => $request->origin,
      'destination'       => $request->destination,
      'weight'            => $request->weight,
      'courier'           => $request->courier
  ]);

  $ongkir = $response['rajaongkir']['results'];

  return response()->json([
      'success' => true,
      'message' => 'Result Cost Ongkir',
      'data'    => $ongkir    
  ]);
  }
}
