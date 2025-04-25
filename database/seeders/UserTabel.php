<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTabel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Develover',
            'email' => 'dev@gmail.com',
            'password' => bcrypt('12345678'),  // Pastikan password terenkripsi
            'role' => 'admin',
        ]);
    }
}
