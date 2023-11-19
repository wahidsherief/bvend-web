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
        Schema::create('machine_product_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machine_id');
            $table->unsignedBigInteger('product_category_id');
            $table->timestamps();
        
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_product_category');
    }
};
