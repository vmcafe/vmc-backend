<?php

namespace App\Context\VoucherController;

use App\Context\Reader;
use App\Models\Voucher;

class GetVoucherByIdReader implements Reader
{

  private $id;
  public function __construct($id)
  {
    $this->id = $id;
  }

  public function read()
  {
    $voucher = Voucher::find($this->id);
    if (is_null($voucher)) {
      throw new \Exception("Voucher tidak ditemukan.", 404);
    }

    return $voucher;
  }
}
