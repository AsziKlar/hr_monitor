<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AgencyMechanismPeriod;

class AgencyMechanismPeriodSeeder extends Seeder
{
    
    public function run(): void
    {
        AgencyMechanismPeriod::create([
            'agency_id' => 1,
            'mechanism_id' => 1,
            'current_period' => 1
        ]);
    }
}
