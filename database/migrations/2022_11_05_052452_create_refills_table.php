<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('machine_id');
            $table->integer('row_no');
            $table->integer('column_no');
            $table->integer('capacity');
            $table->integer('quantity')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refills');
    }
};
