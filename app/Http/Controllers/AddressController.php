<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Address;

class AddressController extends Controller
{
    public function add(Request $request)
    {
        try {
            $rules = [
                'receiver' => 'required|string|max:255',
                'district' => 'required|string|max:255',
                'postal_code' => 'required|string|min:5',
                'phone' => 'required|string|min:10',
                'street' => 'required|string|max:255',
            ];
            $this->validate($request, $rules);
            $address = new Address;
            $user = auth()->user()->id;
            $address->id_user = $user;
            $address->receiver = $request->receiver;
            $address->district = $request->district;
            $address->phone = $request->phone;
            $address->postal_code = $request->postal_code;
            $address->street = $request->street;

            $address->save();
            return $this->responseSuccess($address);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function get()
    {
        $id = auth()->user()->id;
        if (Address::where('id_user', $id)->first()) {
            $hasil = Address::where('id_user', $id)
                ->get();

            return response()
                ->json(['data' => $hasil], 200);
        } else {
            return response()->json([
                'message' => 'data tidak ditemukan',
                'data' => (object) []
            ], 404);
        }
    }

    public function getProvince()
    {
        $response = Http::withHeaders([
            'key' => '45b6241fce218da567bf56d9130d9696'
        ])->get('https://api.rajaongkir.com/starter/province');
        return $response->json();
    }
}