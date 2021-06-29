<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypePersonSeeder extends Seeder
{
    public function run()
    {
        DB::table('type_person')->insert([
            'id' => 0,
            'name' => 'Natural',
            'state' => true,
        ]);
        DB::table('type_person')->insert([
            'id' => 0,
            'name' => 'Jurídica',
            'state' => true,
        ]);
    }
}
