<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // agar pehle se hai to update karega
            [
                'name' => 'Ayesha Siddiqui', 
                'password' => Hash::make('aysha72'),
                'role' => 'admin'
            ]
        );
    }
}
