<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        //ADMIN
        DB::table('users')->insert([
            'name' => 'Administrador del Sistema',
            'state' => true,
            'avatar' => 'users/avatar.png',
            'email' => 'administrador@webapp.com',
            'password' => '$2y$10$.n9cbsO273dzcFf5nj5QU.4WG6LHsK3WrszmUUmIU8IwmufWDn91e', // password = 123456
        ]);
    }
}
