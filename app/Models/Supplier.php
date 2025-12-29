<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        's_name', 'phone', 'address'
    ];

    protected $guarded = ['id'];

    public static $rules = ['s_name' => 'required'];
}
