<?php

namespace App\Context\VoucherController;

use App\Context\Handler;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddVoucherHandler implements Handler
{
  private $request;
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function handle()
  {
    $valid = $this->request->all();
    $voucher = new Voucher();
    DB::transaction(function () use ($valid, $voucher) {
      $voucher->fill($valid);
      $voucher->save();
    });

    return $voucher;
  }
}
