<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user', 'id_product',
        'quantity', 'note'
    ];

    public function products()
    {
        return $this->belongsTo('App\Models\Product', 'id_product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
