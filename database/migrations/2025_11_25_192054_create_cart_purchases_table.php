<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('store_users_id');
            $table->integer('item_id');
            $table->string('transaction_ref');
            $table->string('cart_session');
            $table->string('s_name');
            $table->string('i_name');
            $table->tinyInteger('is_rgb')->default(0);
            $table->tinyInteger('is_bottle')->default(0);
            $table->tinyInteger('no_exchange')->default(0);
            $table->string('qty_bottle')->default(0);
            $table->string('qty');
            $table->decimal('cost_price', 10, 2);
            $table->decimal('price_unit', 10, 2);
            $table->decimal('price_total', 10, 2);
            $table->tinyInteger('is_confirmed')->default(0);
            $table->tinyInteger('deleted')->default(0);
            $table->decimal('amount_paid', 10, 2);
            $table->string('qty_rebate')->default(0);
            $table->tinyInteger('is_rebate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_purchases');
    }
};
