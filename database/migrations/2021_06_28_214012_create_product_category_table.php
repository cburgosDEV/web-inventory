<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->id();
            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idProduct')->unsigned();
            $table->foreign('idProduct')->references('id')->on('product')->onUpdate('no action')->onDelete('no action');

            $table->unsignedBigInteger('idCategory')->unsigned();
            $table->foreign('idCategory')->references('id')->on('category')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_category');
    }
}
