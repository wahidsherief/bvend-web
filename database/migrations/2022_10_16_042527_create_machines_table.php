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
            $table->enum('machine_type', ['store', 'box']);
            $table->integer('no_of_rows');
            $table->integer('no_of_trays');
            $table->integer('locks_per_tray');
            $table->string('qr_code');
            $table->integer('vendors_id')->unique()->nullable();
            $table->string('assign_date')->nullable();
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
