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
        Schema::create('machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('machine_code');
            $table->smallInteger('machine_types_id');
            $table->integer('no_of_rows');
            $table->integer('no_of_columns');
            $table->integer('locks_per_column');
            $table->string('qr_code');
            $table->integer('vendors_id')->nullable();
            $table->string('assign_date')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('machines');
    }
};
