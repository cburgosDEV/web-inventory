<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypePersonTable extends Migration
{
    public function up()
    {
        Schema::create('type_person', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('state')->default(true);

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('type_person');
    }
}
