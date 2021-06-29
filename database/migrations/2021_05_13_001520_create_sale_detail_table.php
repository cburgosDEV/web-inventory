<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailTable extends Migration
{
    public function up()
    {
        Schema::create('sale_detail', function (Blueprint $table) {
            $table->id();
            $table->decimal('unitaryPrice', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->decimal('subTotal', 10, 2);

            //Relations
            $table->unsignedBigInteger('idSale')->unsigned();
            $table->foreign('idSale')->references('id')->on('sale')->onUpdate('no action')->onDelete('no action');

            $table->unsignedBigInteger('idProduct')->unsigned();
            $table->foreign('idProduct')->references('id')->on('product')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_detail');
    }
}
