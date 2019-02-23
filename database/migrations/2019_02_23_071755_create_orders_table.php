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
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->enum('status', ['PENDING', 'PAID', 'SHIPPED'])->index();
            $table->text('address');
            $table->float('total_price')->nullable();
            $table->float('total_weight')->nullable();
            $table->float('shipping_fee')->nullable();
            $table->integer('payment_key')->nullable();
            $table->float('total_payment')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
