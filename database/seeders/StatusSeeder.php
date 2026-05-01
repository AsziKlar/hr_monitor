<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'To be Reviewed',
            'Needs Revision',
            'Approved',
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate([
                'name' => $status
            ]);
        }
    }
}
