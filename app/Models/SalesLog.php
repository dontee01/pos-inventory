<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesLog extends Model
{
    protected $fillable = [
        'transaction_ref', 'users_id', 'item_id', 'd_name', 'i_name', 'is_rgb', 'qty', 'qty_bottle', 'qty_content', 'total', 'amount_paid', 'amount_paid_cash', 'amount_paid_bank', 'receipt', 'name', 'is_debtor_discount', 'difference'
    ];

    protected $guarded = ['id'];

    public static $rules = ['i_name' => 'required'];
}
