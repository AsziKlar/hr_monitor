<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    
    public function definition(): array
    {
        static $statuses = [
            'To be Reviewed',
            'Needs Revision',
            'Approved'
        ];

        return [
            'name' => array_shift($statuses)
        ];
    }
}
