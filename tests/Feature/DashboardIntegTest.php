<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Admin\Index;
use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\Announcement;
use App\Models\Draft;
use App\Models\FieldOffice;
use App\Models\Mechanism;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardIntegTest extends TestCase
{
    use RefreshDatabase;

     public function test_hrmo_dashboard(): void {
        Role::factory()->hrmo()->create();

        Status::factory()->create();

        $fieldOffice = FieldOffice::factory()->create();

        $agency = Agency::factory()->create([
            'field_office_id' => $fieldOffice->id,
        ]);

        $hrmo = User::factory()->hrmo($agency->id)->create();

        $msp = Mechanism::factory()->msp()->create();
        $spms = Mechanism::factory()->spms()->create();
        $praise = Mechanism::factory()->praise()->create();

        $mechanisms = Mechanism::all();

        AgencyMechanismPeriod::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $msp->id,
            'current_period' => 1, 
        ]);

        $draft = Draft::factory()->create([
            'agency_id' => $agency->id,
            'user_id' => $hrmo->id,
            'mechanism_id' => $msp->id,
            'status_id' => 1,
            'period' => 1,
        ]);

        $announcement = Announcement::factory()->withUser($hrmo->id)->create();

        $response = $this->actingAs($hrmo)
            ->get(route('hrmo.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHas('mechanisms');
        $response->assertViewHas('latest_draft_per_mechanism');
        $response->assertViewHas('latestSubmissions');
        $response->assertViewHas('latestAnnouncement');
        $response->assertSee($announcement->title);
        
     }

     public function test_csc_dashboard(): void {
        Role::factory()->administrator()->create();

        $admin = User::factory()->administrator()->create();
        Mechanism::factory()->count(4)->create();
        $mechanism = Mechanism::first();
        $statuses = Status::factory()->count(3)->create();

        $agency = Agency::factory()->create();

        AgencyMechanismPeriod::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'current_period' => 2,
        ]);

        Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'period' => 1,
            'status_id' => 1,
        ]);

        Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'period' => 1,
            'status_id' => 3,
        ]);

        Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'period' => 2,
            'status_id' => 3,
        ]);

        Livewire::actingAs($admin)
        ->test(Index::class)
        ->assertSet("total_drafts_num.{$mechanism->id}", 1)
        ->assertSet("approved_count.{$mechanism->id}", 1)
        ->assertSet("to_be_reviewed_count.{$mechanism->id}", 0);

     }
}
