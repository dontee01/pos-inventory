<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'c_name', 'phone', 'address'
    ];

    protected $guarded = ['id'];

    public static $rules = ['c_name' => 'required'];
}
