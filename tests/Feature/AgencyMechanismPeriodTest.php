<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\Draft;
use App\Models\FieldOffice;
use App\Models\Mechanism;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AgencyMechanismPeriodTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_increment_agency_mechanism_period(): void {
        $admin = User::factory()->administrator()->create();
        $fieldOffice = FieldOffice::factory()->create();

        $agency = Agency::factory()->create([
            'field_office_id' => $fieldOffice->id,
        ]);

        User::factory()->hrmo($agency->id)->create();
        $mechanism = Mechanism::factory()->msp()->create();

        $approvedStatus = Status::factory()->create([
            'name' => 'Approved',
        ]);
        $toBeReviewedStatus = Status::factory()->create([
            'name' => 'To be Reviewed',
        ]);

        AgencyMechanismPeriod::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'current_period' => 1,
        ]);

        $approvedDraft = Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'period' => 1,
            'status_id' => $approvedStatus->id,
        ]);

        $unapprovedDraft = Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'period' => 1,
            'status_id' => $toBeReviewedStatus->id,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.settings.period_increment', [$mechanism, $agency]));
        $response->assertRedirect();
        $response->assertSessionHas(
            'success',
            'Period updated. New batch of drafts for this mechanism.'
        );

        $this->assertDatabaseHas('agency_mechanism_periods', [
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'current_period' => 2,
        ]);
        $this->assertDatabaseHas('drafts', [
            'id' => $approvedDraft->id,
        ]);
        $this->assertDatabaseMissing('drafts', [
            'id' => $unapprovedDraft->id,
        ]);
    }
}
