<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            'role_id' => 1,
            'agency_id' => null,
            'archived_at' => null,
        ];
    }

    public function administrator(): static
    {
        return $this->state(fn () => [
            'role_id' => 1,
            'agency_id' => null,
        ]);
    }

    public function reviewer(): static
    {
        return $this->state(fn () => [
            'role_id' => 2,
            'agency_id' => null,
        ]);
    }

    public function processor(): static
    {
        return $this->state(fn () => [
            'role_id' => 3,
            'agency_id' => null,
        ]);
    }

    public function hrmo(int $agencyId): static
    {
        return $this->state(fn () => [
            'role_id' => 4,
            'agency_id' => $agencyId,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn () => [
            'archived_at' => now(),
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }
}

// $admin = User::factory()->administrator()->create();

// $reviewer = User::factory()->reviewer()->create();

// $processor = User::factory()->processor()->create();

// $hrmo = User::factory()->hrmo($agency->id)->create();

// $archivedUser = User::factory()->administrator()->archived()->create();