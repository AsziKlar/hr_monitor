<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mechanism;

class MechanismSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mechanisms = [
            'Merit Selection Plan',
            'Strategic Performance Management System',
            'Program on Awards & Incentives for Service Excellence',
            'Grievance Machinery',
            'Learning & Development Policy'
        ];

        foreach ($mechanisms as $mechanism){
            Mechanism::firstOrCreate([
                'name' => $mechanism
            ]);
        }
    }
}
