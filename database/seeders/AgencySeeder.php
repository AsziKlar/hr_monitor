<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agency;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        Agency::create([
            'name' => 'Department of Health',
            'email' => 'doh@mail.com'
        ]);
        Agency::create([
            'name' => 'Philippine Science High School - NMC',
            'email' => 'pshs-nmc@mail.com'
        ]);
    }
}
