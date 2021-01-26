<?php

namespace App\Context\VoucherController;

use App\Context\HasPaginate;
use App\Context\Reader;
use App\Models\Voucher;
use Illuminate\Http\Request;

class GetActiveVoucherReader implements Reader
{
  use HasPaginate;

  public function __construct(Request $request)
  {
    $this->request = $request;
    $this->data = Voucher::whereNull('deleted_at');
  }

  public function read()
  {
  }
}
