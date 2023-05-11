<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('state')->default(true);
            $table->string('avatar', 255)->default('users/avatar.png');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

        });
    }
}
