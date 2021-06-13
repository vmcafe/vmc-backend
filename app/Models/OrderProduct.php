<?php

/**
 * Generated by Yohni
 * https://github.com/yohni
 * yohni.123@gmail.com
 **/

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class OrderProduct extends Pivot
{
    public $incrementing = true;
    protected $table = 'ordersproducts';

    public function products()
    {
        return $this->belongsTo('App\Models\Product', 'id_product');
    }
}