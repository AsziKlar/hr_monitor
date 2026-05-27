<?php

namespace Database\Factories;

use App\Models\FieldOffice;
use Illuminate\Database\Eloquent\Factories\Factory;


class FieldOfficeFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'name' => fake()->city(),
            'description' => fake()->sentence(),
        ];
    }
}


// $fieldOffice = FieldOffice::factory()->create();