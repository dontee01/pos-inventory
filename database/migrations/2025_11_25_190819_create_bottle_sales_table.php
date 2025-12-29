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
        Schema::create('bottle_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('store_users_id')->nullable();
            $table->integer('sales_users_id')->nullable();
            $table->integer('item_id');
            $table->string('transaction_ref');
            $table->string('d_name');
            $table->string('i_name');
            $table->string('c_name');
            $table->string('qty_bottle_content');
            $table->decimal('price_unit', 10, 2);
            $table->decimal('price_total', 10, 2);
            $table->string('comment')->nullable();
            $table->tinyInteger('is_confirmed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bottle_sales');
    }
};
