<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name', '50');
            $table->string('description', '500')->nullable();
            $table->decimal('minPrice', 10, 2)->nullable();
            $table->decimal('stock', 10, 2)->default(0)->nullable();
            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idUnit')->unsigned();
            $table->foreign('idUnit')->references('id')->on('unit')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product');
    }
}
