<?php

namespace App\Http\Controllers;

use App\Context\VoucherController\AddVoucherHandler;
use App\Context\VoucherController\EditVoucherHandler;
use App\Context\VoucherController\GetActiveVoucherReader;
use App\Context\VoucherController\GetVoucherByIdReader;
use App\Context\VoucherController\RemoveVoucherHandler;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
  public function add(Request $request)
  {
    $rules = [
      'name' => 'required',
      'detail' => 'required|min:10',
      'active_until' => 'required|date|after:tomorrow',
      'max_cut' => 'required',
      'promo_code' => 'required|unique:vouchers|max:7',
      'percentage' => 'required'
    ];

    return $this->executeHandler(new AddVoucherHandler($request), $request, $rules);
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
