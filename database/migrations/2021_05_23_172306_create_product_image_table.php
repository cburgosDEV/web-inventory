<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImageTable extends Migration
{
    public function up()
    {
        Schema::create('product_image', function (Blueprint $table) {
            $table->id();
            $table->string('url')->default('public/img/no/image.jpg');
            $table->boolean('isPrincipal')->default(false);
            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idProduct')->unsigned();
            $table->foreign('idProduct')->references('id')->on('product')->onUpdate('no action')->onDelete('no action');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_image');
    }
}
