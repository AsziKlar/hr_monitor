<?php

namespace Tests\Feature;

use App\Models\Agency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Draft;
use App\Models\Mechanism;
use App\Models\Status;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_retrieved_drafts_for_admin(){
        $mechanisms = Mechanism::factory()->count(5)->create();
        $agency = Agency::factory()->count(3)->create();
        $status = Status::factory()->count(3)->create();
        $collectionOfdrafts = Draft::factory()->count(4)->state(fn () => [
            'mechanism_id' => $mechanisms->random()->id,
            'agency_id' => $agency->random()->id,
            'status_id'=> 2
        ])->create();

        // dump($collectionOfdrafts->toArray());
        $mechanisms = Mechanism::all();

        $drafts_to_be_reviewed = [];

        foreach ($mechanisms as $mechanism) {
            $drafts = Draft::where('status_id',1)
                                ->where('mechanism_id', $mechanism->id)
                                ->get();

            $drafts_to_be_reviewed[$mechanism->name] = $drafts;
        }

        // dd($drafts_to_be_reviewed);
        foreach ($drafts_to_be_reviewed as $drafts){
            $this->assertFalse($drafts->isNotEmpty());
        }
    }
    public function test_retrieved_drafts_for_admin(){
        $mechanisms = Mechanism::factory()->count(5)->create();
        $agency = Agency::factory()->count(3)->create();
        $status = Status::factory()->count(3)->create();
        $collectionOfdrafts = Draft::factory()->count(50)->state(fn () => [
            'mechanism_id' => $mechanisms->random()->id,
            'agency_id' => $agency->random()->id,
            'status_id'=> $status->random()->id
        ])->create();

        // dump($collectionOfdrafts->toArray());
        $mechanisms = Mechanism::all();

        $drafts_to_be_reviewed = [];

        foreach ($mechanisms as $mechanism) {
            $drafts = Draft::where('status_id',1)
                                ->where('mechanism_id', $mechanism->id)
                                ->get();

            $drafts_to_be_reviewed[$mechanism->name] = $drafts;
        }

        // dd($drafts_to_be_reviewed);
        foreach ($drafts_to_be_reviewed as $drafts){
            $this->assertTrue($drafts->isNotEmpty());
        }
    }

    
}
