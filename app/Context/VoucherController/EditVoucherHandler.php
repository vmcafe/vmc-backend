<?php

namespace App\Context\VoucherController;

use App\Context\Handler;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditVoucherHandler implements Handler
{
  private $id;
  private $request;

  public function __construct($id, Request $request)
  {
    $this->id = $id;
    $this->request = $request;
  }

  public function handle()
  {
    $valid = $this->request->all();
    $voucher = Voucher::find($this->id);
    if (is_null($voucher)) {
      throw new \Exception("Voucher tidak ditemukan.", 404);
    }
    DB::transaction(function () use ($valid, $voucher) {
      $voucher->fill($valid);
      $voucher->save();
    });

    return $voucher;
  }
}
