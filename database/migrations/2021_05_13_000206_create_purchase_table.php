<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTable extends Migration
{
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->id();
            $table->decimal('totalPrice', 10, 2);
            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idSupplier')->unsigned();
            $table->foreign('idSupplier')->references('id')->on('supplier')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase');
    }
}
