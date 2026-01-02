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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');
            $table->integer('categories_id');
            $table->string('i_name');
            $table->tinyInteger('is_rgb')->default(0);
            $table->string('qty')->nullable();
            $table->string('qty_bottle')->nullable();
            $table->string('qty_content')->nullable();
            $table->decimal('cost_price', 10, 2);
            $table->decimal('price_unit', 10, 2);
            $table->enum('status', ['inactive', 'active'])->default('active');
            $table->timestamps();
            // optimize--make iname unique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
