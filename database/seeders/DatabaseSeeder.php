<?php

namespace Database\Seeders;

use App\Models\Mechanism;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\StatusSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {



        Role::firstOrCreate(['name' => 'Administrator']);
        Role::firstOrCreate(['name' => 'Reviewer']);
        Role::firstOrCreate(['name' => 'Processor']);
        Role::firstOrCreate(['name' => 'HRMO']);

        Status::firstOrCreate(['name' => 'To be Reviewed']);
        Status::firstOrCreate(['name' => 'Needs Revision']);
        Status::firstOrCreate(['name' => 'Approved']);

        Mechanism::firstOrCreate(
            ['name' => 'Merit Selection Plan'],
            ['description' => 'MSP']
        );

        Mechanism::firstOrCreate(
            ['name' => 'Strategic Performance Management System'],
            ['description' => 'SPMS']
        );

        Mechanism::firstOrCreate(
            ['name' => 'Program on Awards and Incentives for Service Excellence'],
            ['description' => 'PRAISE']
        );

        Mechanism::firstOrCreate(
            ['name' => 'Grievance Machinery'],
            ['description' => 'GM']
        );

        Mechanism::firstOrCreate(
            ['name' => 'Learning and Development Policy'],
            ['description' => 'L&D']
        );

        User::firstOrCreate(
            ['email' => 'test@mail.com'],

            ['name' => 'Test Admin',
            'password' => Hash::make('123456789'),
            'role_id' => 1,
            'agency_id' => NULL
            ]
        );

        // $this->call([
        //     StatusSeeder::class,
        // ]);

        // $this->call([
        //     MechanismSeeder::class,
        // ]);
        // $this->call([
        //    FieldOfficeSeeder::class,
        // ]);
        // $this->call([
        //    AgencySeeder::class,
        // ]);

        // $this->call([
        //    RoleSeeder::class,
        // ]);
        // $this->call([
        //     UserSeeder::class
        // ]);

        // $this->call([
        //     AnnouncementSeeder::class
        // ]);

        // $this->call([
        //     AgencyMechanismPeriodSeeder::class
        // ]);



        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
