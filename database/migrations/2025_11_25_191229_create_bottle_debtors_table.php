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
        Schema::create('bottle_debtors', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');
            $table->integer('item_id');
            $table->string('transaction_ref');
            $table->string('i_name');
            $table->string('d_name');
            $table->string('error_type');
            $table->string('qty_bottle');
            $table->decimal('amount_paid', 10, 2);
            $table->tinyInteger('is_rgb_content')->default(0);
            $table->tinyInteger('is_cleared')->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bottle_debtors');
    }
};
