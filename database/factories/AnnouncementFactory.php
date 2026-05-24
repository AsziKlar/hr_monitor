<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'body' => fake()->sentence(15)
        ];
    }

    public function withUser($userId): static {
        return $this->state(fn (array $attributes) => [
            'user_id' => $userId
        ]);
    }
}
