<?php

namespace App\Context\VoucherController;

use App\Context\Handler;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RemoveVoucherHandler implements Handler
{
  private $id;
  public function __construct($id)
  {
    $this->id = $id;
  }

  public function handle()
  {
    $voucher = Voucher::find($this->id);
    if (is_null($voucher)) {
      throw new \Exception("Voucher tidak ditemukan.", 404);
    }

    DB::transaction(function () use ($voucher) {
      $voucher->deleted_at = Carbon::now();
      $voucher->save();
    });

    return $voucher;
  }
}
