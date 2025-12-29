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
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('store_users_id')->nullable();
            $table->integer('sales_users_id')->nullable();
            $table->integer('item_id');
            $table->string('transaction_ref');
            $table->string('d_name')->nullable();
            $table->string('i_name')->nullable();
            $table->string('c_name');
            $table->tinyInteger('is_rgb')->default(0);
            $table->string('qty_content')->nullable();
            $table->string('qty_bottle')->nullable();
            $table->string('qty');
            $table->string('returned_qty')->nullable();
            $table->string('returned_bottle')->nullable();
            $table->decimal('price_unit', 10, 2);
            $table->decimal('price_total', 10, 2);
            $table->tinyInteger('is_confirmed')->default(0);
            $table->tinyInteger('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_orders');
    }
};
