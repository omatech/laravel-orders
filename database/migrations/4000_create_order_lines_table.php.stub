<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_lines', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');

//            $table->integer('quantity')->default(1);
//
//            $table->decimal('unit_price');
//            $table->decimal('total_base_price');
//            $table->decimal('shipping_price')->default(0.00);
//            $table->decimal('tax_decimal')->default(0.00);
//            $table->decimal('tax_amount')->default(0.00);
//            $table->decimal('total_price_without_taxes');
//            $table->decimal('total_price');
//            $table->string('currency_code');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_lines');
    }
}
