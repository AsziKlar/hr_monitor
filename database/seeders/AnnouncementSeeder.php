<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    
    public function run(): void
    {
        Announcement::create([
            'user_id' => 3,
            'title' => 'Jennie Jennie Jennie',
            'body'=> 'My friends are saying nanana just pablo escobarrrz'
        ]);
    }
}
