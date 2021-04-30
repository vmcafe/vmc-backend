<?php

/**
 * Generated by Yohni
 * https://github.com/yohni
 * yohni.123@gmail.com
 **/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user', 'receiver', 'phone', 'district', ' postal_code',
        'street', 'selected',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    
}
