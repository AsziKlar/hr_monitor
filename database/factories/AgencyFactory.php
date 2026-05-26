<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'email_address' => fake()->companyEmail(),

            'field_office_id' => null,

            'abbreviation' => fake()->lexify('???'),
            'head' => fake()->name(),
        ];
    }
}

// $fieldOffice = FieldOffice::factory()->create();

// $agency = Agency::factory()->create([
//     'field_office_id' => $fieldOffice->id,
// ]);


// $fieldOffice = FieldOffice::factory()->create();

// $agency = Agency::factory()->create([
//     'field_office_id' => $fieldOffice->id,
// ]);