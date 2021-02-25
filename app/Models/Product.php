<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'products';
  protected $primaryKey = 'id';
  protected $fillable = [
    'name', 'description', 'amount', 'price', 'best', 'photo', 'id_category'
  ];

  public function cart()
  {
    return $this->hasMany('App\Models\Cart', 'id_product');
  }
  public function category()
  {
    return $this->belongsTo('App\Models\Category', 'id_category');
  }
  public function order()
  {
    return $this->belongsToMany('App\Models\Order')
      ->using('App\Models\OrderProduct')
      ->withPivot([
        'quantity',
        'cost',
      ]);
  }
}
