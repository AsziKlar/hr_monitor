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
            'role_id' => 4,
            'agency_id' => 1,
            'name' => 'Jessica Vasallo',
            'email' => 'jess@mail.com',
            'password' => Hash::make('123456789'),

        ]);
    }
}
