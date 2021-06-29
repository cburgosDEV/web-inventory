<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('name', '50');
            $table->string('dni', '8')->nullable();
            $table->string('ruc', '11')->nullable();
            $table->string('phone', '20')->nullable();
            $table->string('address', '50')->nullable();
            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idTypePerson')->unsigned();
            $table->foreign('idTypePerson')->references('id')->on('type_person')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplier');
    }
}
