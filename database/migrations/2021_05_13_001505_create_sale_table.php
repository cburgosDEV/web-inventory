<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleTable extends Migration
{
    public function up()
    {
        Schema::create('sale', function (Blueprint $table) {
            $table->id();
            $table->decimal('totalPrice', 10, 2);
            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idCustomer')->unsigned();
            $table->foreign('idCustomer')->references('id')->on('customer')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale');
    }
}
