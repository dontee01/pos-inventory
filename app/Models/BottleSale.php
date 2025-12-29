<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BottleSale extends Model
{
    protected $fillable = [
        'transaction_ref', 'store_users_id', 'sales_users_id', 'd_name', 'i_name', 'c_name', 'is_confirmed', 'qty_bottle_content', 'price_unit', 'price_total', 'comment'
    ];

    protected $guarded = ['id'];

    public static $rules = ['i_name' => 'required'];
}
