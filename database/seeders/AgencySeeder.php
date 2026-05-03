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
            'email_address' => 'doh@mail.com',
            'head' => 'Christina Pioquinto',
            'field_office_id' => 1
        ]);
        Agency::create([
            'name' => 'Philippine Science High School - NMC',
            'email_address' => 'pshs-nmc@mail.com',
            'head' => 'Paul Alarde',
            'field_office_id' => 1
        ]);
        Agency::create([
            'name' => 'Northern Mindanao Medical Center',
            'email_address' => 'nmmc@mail.com',
            'head' => 'Lucian Cagata',
            'field_office_id' => 2

        ]);
    }
}
