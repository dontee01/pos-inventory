<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'users_id', 'categories_id', 'i_name', 'is_rgb', 'qty', 'qty_bottle', 'qty_content', 'cost_price', 'price_unit'
    ];

    protected $guarded = ['id'];

    public static $rules = ['i_name' => 'required'];

}
