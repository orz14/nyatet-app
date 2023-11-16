<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 30; $i++) {
            Todo::create([
                'user_id' => 1,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'content' => Crypt::encryptString(fake()->sentence()),
                'date' => '2023-04-04',
                'created_at' => '2023-04-04 00:36:25',
            ]);
        }

        for ($i = 0; $i < 20; $i++) {
            Todo::create([
                'user_id' => 1,
                'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
                'content' => Crypt::encryptString(fake()->sentence()),
                'date' => date('Y-m-d'),
            ]);
        }
    }
}
