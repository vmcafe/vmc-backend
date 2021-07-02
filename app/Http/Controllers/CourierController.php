<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use App\Models\Province;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CourierController extends Controller
{
  public function getProvince()
  {
    $daftarProvinsi = RajaOngkir::provinsi()->all();
    return $daftarProvinsi;
  }

  public function getCity()
  {
    $response = Http::withHeaders([
      'key' => '45b6241fce218da567bf56d9130d9696'
    ])->get('https://api.rajaongkir.com/starter/city');
    return $response->json();
  }

  public function getCities($id)
  {
    $city = City::where('province_id', $id)->pluck('name', 'city_id');
    return response()->json($city);
  }

  public function getCost(Request $request)
  {
    $cost = RajaOngkir::ongkosKirim([
      'origin'        => $request->city_origin, // ID kota/kabupaten asal
      'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
      'weight'        => $request->weight, // berat barang dalam gram
      'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
    ])->get();
    return response()->json($cost);
  }

  public function postCity()
  {
    $daftarProvinsi = RajaOngkir::provinsi()->all();
    foreach ($daftarProvinsi as $provinceRow) {
      Province::create([
        'province_id' => $provinceRow['province_id'],
        'name'        => $provinceRow['province'],
      ]);
      $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();
      foreach ($daftarKota as $cityRow) {
        City::create([
          'province_id'   => $provinceRow['province_id'],
          'city_id'       => $cityRow['city_id'],
          'city_name'          => $cityRow['city_name'],
        ]);
      }
    }
  }
}
