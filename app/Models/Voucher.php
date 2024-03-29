<?php

/**
 * Generated by Yohni
 * https://github.com/yohni
 * yohni.123@gmail.com
 **/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected  $table = 'vouchers';

    protected $fillable = [
        'active_until', 'max_cut', 'promo_code', 'percentage'
    ];

    protected $hidden = ['deleted_at'];
}
