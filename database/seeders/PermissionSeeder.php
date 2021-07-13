<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        //ADMIN
        $user = User::findOrFail(1);
        $user->assignRole(Role::findOrFail(1));
    }
}
