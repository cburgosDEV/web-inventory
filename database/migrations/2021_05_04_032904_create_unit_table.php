<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitTable extends Migration
{
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->id();
            $table->string('name', '50');
            $table->string('symbol', '10');
            $table->boolean('state')->default(true);

            //Stamps
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('unit');
    }
}
