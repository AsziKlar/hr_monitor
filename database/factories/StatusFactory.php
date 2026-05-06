<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'name' => 'To be Reviewed'
        ];
    }
}
