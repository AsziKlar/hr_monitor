<?php

namespace Database\Factories;

use App\Models\Mechanism;
use Illuminate\Database\Eloquent\Factories\Factory;

class MechanismFactory extends Factory
{
    public function definition(): array
    {
        static $mechanisms = [
            'MSP',
            'SPMS',
            'PRAISE',
            'GM',
            'LDP'
        ];

        return [
            'name' => array_shift($mechanisms),
            'is_active' => true
        ];
    }
}
