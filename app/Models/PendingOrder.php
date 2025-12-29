<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    protected $fillable = [
        'transaction_ref', 'store_users_id', 'sales_users_id', 'item_id', 'd_name', 'i_name', 'c_name', 'is_rgb', 'is_confirmed', 'deleted', 'qty_content', 'qty_bottle', 'qty', 'returned_qty', 'returned_bottle', 'price_unit', 'price_total'
    ];

    protected $guarded = ['id'];

    public static $rules = ['i_name' => 'required'];
}
