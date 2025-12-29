<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BottleDebtor extends Model
{
    protected $fillable = [
        'transaction_ref', 'users_id', 'd_name', 'i_name', 'error_type', 'is_cleared', 'is_rgb_content', 'qty_bottle', 'amount_paid', 'comment'
    ];

    protected $guarded = ['id'];

    public static $rules = ['i_name' => 'required'];
}
