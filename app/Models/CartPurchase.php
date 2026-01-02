<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartPurchase extends Model
{
    protected $fillable = [
        'transaction_ref', 'cart_session', 'store_users_id', 'item_id', 's_name', 'i_name', 'no_exchange', 'is_rgb', 'is_bottle', 'is_confirmed', 'qty_bottle', 'qty', 'cost_price', 'price_unit', 'price_total', 'deleted', 'qty_rebate', 'is_rebate', 'amount_paid'
    ];

    protected $guarded = ['id'];

    public static $rules = ['i_name' => 'required'];
}
