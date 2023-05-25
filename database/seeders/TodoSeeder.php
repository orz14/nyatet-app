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
        Todo::create([
            'user_id' => 1,
            'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
            'content' => Crypt::encryptString('Ingin menguasai dunia'),
            'date' => '2023-04-04',
            'created_at' => '2023-04-04 00:36:25',
        ]);

        Todo::create([
            'user_id' => 1,
            'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
            'content' => Crypt::encryptString('Ingin memiliki dia'),
            'date' => '2023-04-04',
            'created_at' => '2023-04-04 00:40:00',
        ]);

        Todo::create([
            'user_id' => 1,
            'slug' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10),
            'content' => Crypt::encryptString('Lebih baik dari hari kemarin'),
            'date' => '2023-05-04',
            'created_at' => '2023-05-04 00:40:00',
        ]);

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
