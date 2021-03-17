<?php

namespace App\Http\Controllers;

use App\Context\VoucherController\AddVoucherHandler;
use App\Context\VoucherController\EditVoucherHandler;
use App\Context\VoucherController\GetActiveVoucherReader;
use App\Context\VoucherController\GetVoucherByIdReader;
use App\Context\VoucherController\RemoveVoucherHandler;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
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
    $voucher = new Voucher;
    $voucher->active_until = $request->active_until;
    $voucher->max_cut = $request->max_cut;
    $voucher->promo_code = $request->promo_code;
    $voucher->percentage = $request->percentage;

    $voucher->save();

    return $this->responseSuccess($voucher);

    // return $this->executeHandler(new AddVoucherHandler($request), $request, $rules);
  }

  public function getActive(Request $request)
  {
    return $this->responsePagination(new GetActiveVoucherReader($request));
  }

  public function get($id)
  {
    return $this->executeReader(new GetVoucherByIdReader($id));
  }

  public function edit($id, Request $request)
  {
    $rules = [
      'name' => 'required',
      'detail' => 'required|min:10',
      'active_until' => 'required|date|after:tomorrow',
      'max_cut' => 'required',
      'promo_code' => 'required|unique:vouchers|max:7',
      'percentage' => 'required'
    ];

    return $this->executeHandler(new EditVoucherHandler($id, $request));
  }

  public function remove($id)
  {
    return $this->executeHandler(new RemoveVoucherHandler($id));
  }
}
