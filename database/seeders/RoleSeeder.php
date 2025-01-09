<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['role' => 'admin']);
        Role::create(['role' => 'user']);
        Role::create(['role' => 'mobile-dev']);
    }
}
