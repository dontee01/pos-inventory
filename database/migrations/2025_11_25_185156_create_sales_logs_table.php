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
        Schema::create('sales_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');
            // $table->integer('item_id');
            $table->string('d_name');
            $table->string('transaction_ref');
            // $table->string('i_name')->nullable();
            // $table->tinyInteger('is_rgb')->default(0);
            $table->string('qty')->nullable();
            // $table->string('qty_bottle')->nullable();
            // $table->string('qty_content')->nullable();
            $table->decimal('total', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_debit_card']);
            $table->string('receipt');
            $table->string('name');
            $table->decimal('difference', 10, 2);
            $table->tinyInteger('is_debtor_discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_logs');
    }
};
