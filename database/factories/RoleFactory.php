<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Administrator',
                'Reviewer',
                'Processor',
                'HRMO',
            ]),
        ];
    }

    public function administrator(): static
    {
        return $this->state(fn () => [
            'id' => 1,
            'name' => 'Administrator',
        ]);
    }

    public function reviewer(): static
    {
        return $this->state(fn () => [
            'id' => 2,
            'name' => 'Reviewer',
        ]);
    }

    public function processor(): static
    {
        return $this->state(fn () => [
            'id' => 3,
            'name' => 'Processor',
        ]);
    }

    public function hrmo(): static
    {
        return $this->state(fn () => [
            'id' => 4,
            'name' => 'HRMO',
        ]);
    }
}


// Role::factory()->administrator()->create();

// Role::factory()->reviewer()->create();

// Role::factory()->processor()->create();

// Role::factory()->hrmo()->create();

// Role::factory()->administrator()->create();

// $admin = User::factory()->administrator()->create();