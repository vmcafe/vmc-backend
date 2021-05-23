<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
    return $response->body();
  }
}
