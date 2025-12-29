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
        Schema::create('purchase_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->string('transaction_ref');
            $table->string('s_name');
            $table->string('i_name')->nullable();
            $table->tinyInteger('is_rgb')->default(0);
            $table->tinyInteger('is_bottle')->default(0);
            $table->tinyInteger('no_exchange')->default(0);
            $table->string('qty')->nullable();
            $table->string('qty_bottle')->nullable();
            $table->decimal('price_unit', 10, 2);
            $table->decimal('price_total', 10, 2);
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
        Schema::dropIfExists('purchase_logs');
    }
};
