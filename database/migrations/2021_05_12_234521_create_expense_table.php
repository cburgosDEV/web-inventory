<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseTable extends Migration
{
    public function up()
    {
        Schema::create('expense', function (Blueprint $table) {
            $table->id();
            $table->string('name', '250');
            $table->decimal('amount', 10, 2);
            $table->boolean('state')->default(true);

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expense');
    }
}
