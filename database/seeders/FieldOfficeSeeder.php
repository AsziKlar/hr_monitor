<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FieldOffice;

class FieldOfficeSeeder extends Seeder
{
    
    public function run(): void
    {
        $field_offices = [
            'FO1',
            'FO2',
            'FO3'
        ];

        foreach ($field_offices as $field_office){
            FieldOffice::firstOrCreate([
                'name' => $field_office
            ]);
        }
    }
}
