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
            'email_address' => fake()->companyEmail()
        ];
    }
}
