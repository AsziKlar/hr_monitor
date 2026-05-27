<?php

namespace Database\Factories;

use App\Models\Mechanism;
use Illuminate\Database\Eloquent\Factories\Factory;

class MechanismFactory extends Factory
{
    protected $model = Mechanism::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->word(),
            'is_active' => true,
        ];
    }

    public function msp(): static
    {
        return $this->state(fn () => [
            'id' => 1,
            'name' => 'Merit Selection Plan',
            'description' => 'MSP',
        ]);
    }

    public function spms(): static
    {
        return $this->state(fn () => [
            'id' => 2,
            'name' => 'Strategic Performance Management System',
            'description' => 'SPMS',
        ]);
    }

    public function praise(): static
    {
        return $this->state(fn () => [
            'id' => 3,
            'name' => 'Program on Awards and Incentives for Service Excellence',
            'description' => 'PRAISE',
        ]);
    }

    public function gm(): static
    {
        return $this->state(fn () => [
            'id' => 4,
            'name' => 'Grievance Machinery',
            'description' => 'GM',
        ]);
    }

    public function ld(): static
    {
        return $this->state(fn () => [
            'id' => 5,
            'name' => 'Learning and Development',
            'description' => 'L&D',
        ]);
    }
}

// $mechanism = Mechanism::factory()->msp()->create();