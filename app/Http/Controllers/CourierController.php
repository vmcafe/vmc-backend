<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courier;
class CourierController extends Controller
{
    public function add(Request $request)
  {
    $rules = [
      // 'name' => 'required',
      // 'detail' => 'required|min:10',
      'active_until' => 'required|after:tomorrow',
      'max_cut' => 'required',
      'promo_code' => 'required|unique:vouchers|max:7',
      'percentage' => 'required'
    ];
    $this->validate($request, $rules);
    $courier = new Courier;
    $courier->active_until = $request->active_until;
    $courier->max_cut = $request->max_cut;
    $courier->promo_code = $request->promo_code;
    $courier->percentage = $request->percentage;

    $courier->save();

    return $this->responseSuccess($voucher);
}
