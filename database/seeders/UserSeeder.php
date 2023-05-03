<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Oriz Wahyu N',
            'username' => 'orz14',
            'email' => 'oriezt.id@gmail.com',
            'password' => '$2y$10$qTeaHCKGDVCIVq9nCcjgM.B1pqeqi60WJ9WGmJB82Z.UAvEzU6sjK',
            'role_id' => 1,
        ]);

        User::create([
            'name' => 'Wahyu Choirunnisa P',
            'username' => 'cp',
            'email' => 'wahyuchoirunnisa15@gmail.com',
            'password' => '$2y$10$9RSQCzm48xepDk.G9jQwo.SKB1poD/7/r4CVFaMWl7PvkP5Ufkb4.',
            'role_id' => 2,
        ]);
    }
}
