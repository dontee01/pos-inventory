<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseLog extends Model
{
    protected $fillable = [
        'transaction_ref', 'item_id', 's_name', 'i_name', 'is_rgb', 'is_bottle', 'no_exchange', 'qty', 'qty_bottle', 'cost_price', 'price_unit', 'price_total', 'qty_rebate', 'is_rebate', 'amount_paid'
    ];

    protected $guarded = ['id'];

    public static $rules = ['i_name' => 'required'];
}
