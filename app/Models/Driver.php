<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'd_name', 'phone', 'address'
    ];

    protected $guarded = ['id'];

    public static $rules = ['d_name' => 'required'];
}
