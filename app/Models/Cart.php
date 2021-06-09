<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user', 'quantity'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')
            ->using('App\Models\CartProduct')
            ->withPivot([
                'quantity',
                'id_product',
                'cost',
            ]);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
