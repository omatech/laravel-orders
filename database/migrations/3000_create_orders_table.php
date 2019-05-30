<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

//            $table->string('status');
//            $table->string('code')->unique();

//            $table->string('customer_name')->nullable();
//            $table->string('customer_phone')->nullable();
//            $table->string('customer_email')->nullable();
//
//            $table->string('shipping_address_line1')->nullable();
//            $table->string('shipping_address_line2')->nullable();
//            $table->string('shipping_city')->nullable();
//            $table->string('shipping_province')->nullable();
//            $table->string('shipping_postal_code')->nullable();
//
//            $table->string('billing_name')->nullable();
//            $table->string('billing_cif')->nullable();
//            $table->string('billing_fiscal_address_line1')->nullable();
//            $table->string('billing_fiscal_address_line2')->nullable();
//            $table->string('billing_billing_postal_code')->nullable();
//            $table->string('billing_billing_city')->nullable();
//            $table->string('billing_billing_province')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
