<?php

namespace Database\Factories;

use App\Models\Mechanism;
use Illuminate\Database\Eloquent\Factories\Factory;

class MechanismFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Merit Selection Plan',
            'is_active' => true,
        ];
    }
}
