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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('machine_id');
            $table->string('bkash_merchant_number');
            $table->string('customer_number');
            $table->string('invoice_no');
            $table->string('bkash_trx_id')->nullable();
            $table->integer('product_id');
            $table->integer('total_amount');
            $table->integer('payment_method_id')->nullable();
            $table->enum('status', ['Completed', 'Failed'])->default('Failed');
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
        Schema::dropIfExists('transactions');
    }
};
