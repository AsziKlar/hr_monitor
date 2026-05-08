<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
 
    public function run(): void
    {
        User::factory()->create([
            'role_id' => 1,
            'name' => 'Paul Conrad S. Navidad',
            'email' => 'conrad@mail.com',
            'password' => Hash::make('123456789'),

        ]);
    }
}
