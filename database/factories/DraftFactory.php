<?php

namespace Database\Factories;

use App\Models\Draft;
use Illuminate\Database\Eloquent\Factories\Factory;

class DraftFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'agency_id' => 1,
            'mechanism_id' => 1,
            'period' => 1,
            'status_id' => 1,
            'file_name' => fake()->word() . '.pdf',
            'file_path' => 'drafts/' . fake()->word() . '.pdf'
        ];
    }
    
}
