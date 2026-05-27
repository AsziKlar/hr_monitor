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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DraftIntegTest extends TestCase
{
    use RefreshDatabase;
    public function test_hrmo_view_drafts_current_period_only(): void {
        $fieldOffice = FieldOffice::factory()->create();
        $agency = Agency::factory()->create([
            'field_office_id' => $fieldOffice->id,
        ]);

        Role::factory()->hrmo()->create();

        $hrmo = User::factory()->hrmo($agency->id)->create();
        $mechanism = Mechanism::factory()->msp()->create();
        $status = Status::factory()->create([
            'name' => 'To be Reviewed',
        ]);

        AgencyMechanismPeriod::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'current_period' => 2,
        ]);

        $currentDraft = Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'status_id' => $status->id,
            'period' => 2,
        ]);

        $oldDraft = Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'status_id' => $status->id,
            'period' => 1,
        ]);

        $response = $this->actingAs($hrmo)
            ->get(route('hrmo.drafts.index', $mechanism));
        $response->assertStatus(200);
        $response->assertViewIs('drafts.index');
        $response->assertViewHas('drafts', function ($drafts) use ($currentDraft, $oldDraft) {
            return $drafts->contains($currentDraft)
                && ! $drafts->contains($oldDraft);
        });

        $response->assertViewHas('mechanism');
        $response->assertViewHas('latestDraft');
    }
    public function test_admin_view_current_period_latest_drafts_per_agency(): void{
        Role::factory()->administrator()->create();
        $admin = User::factory()->administrator()->create();
        $fieldOffice = FieldOffice::factory()->create();

        $agency = Agency::factory()->create([
            'field_office_id' => $fieldOffice->id,
        ]);
        $mechanism = Mechanism::factory()->msp()->create();

        $status = Status::factory()->create();
        AgencyMechanismPeriod::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'current_period' => 2,
        ]);

        $oldPeriodDraft = Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'status_id' => $status->id,
            'period' => 1,
        ]);

        $olderCurrentDraft = Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'status_id' => $status->id,
            'period' => 2,
        ]);

        $latestCurrentDraft = Draft::factory()->create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'status_id' => $status->id,
            'period' => 2,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.drafts.index', $mechanism));

        $response->assertStatus(200);
        $response->assertViewIs('admin.index');
        $response->assertViewHas('mechanism');
        $response->assertViewHas('drafts', function ($drafts) use ($oldPeriodDraft, $olderCurrentDraft, $latestCurrentDraft) {
            return $drafts->contains('id', $latestCurrentDraft->id)
                && ! $drafts->contains('id', $olderCurrentDraft->id)
                && ! $drafts->contains('id', $oldPeriodDraft->id);
        });
    }
    public function test_can_submit_draft(): void{
        Storage::fake('public');

        Role::factory()->administrator()->create();
        Role::factory()->reviewer()->create();
        Role::factory()->processor()->create();
        Role::factory()->hrmo()->create();


        $fieldOffice = FieldOffice::factory()->create();

        $agency = Agency::factory()->create([
            'field_office_id' => $fieldOffice->id,
        ]);
        $hrmo = User::factory()->hrmo($agency->id)->create();

        $mechanism = Mechanism::factory()->msp()->create();
        $status = Status::factory()->create();
        AgencyMechanismPeriod::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'current_period' => 1,
        ]);

        $response = $this->actingAs($hrmo)
            ->post(route('drafts.store'), [
                'mechanism_id' => $mechanism->id,

                'file' => UploadedFile::fake()->create(
                    'draft.pdf',
                    100,
                    'application/pdf'
                ),

            ]);

        $response->assertRedirect();
        $response->assertSessionHas(
            'success',
            'Draft submitted successfully!'
        );
        $this->assertDatabaseHas('drafts', [
            'mechanism_id' => $mechanism->id,
            'user_id' => $hrmo->id,
            'agency_id' => $agency->id,
            'status_id' => $status->id,
            'period' => 1,
        ]);
    }

    public function test_can_approve_draft(): void {
        Role::factory()->administrator()->create();
        Role::factory()->hrmo()->create();
        $admin = User::factory()->administrator()->create();
        $fieldOffice = FieldOffice::factory()->create();

        $agency = Agency::factory()->create([
            'field_office_id' => $fieldOffice->id
        ]);

        $hrmo = User::factory()->hrmo($agency->id)->create();

        $mechanism = Mechanism::factory()->msp()->create();
        $statuses = Status::factory()->count(3)->create();

        $draft = Draft::factory()->create([
            'mechanism_id' => $mechanism->id,
            'user_id' => $admin->id,
            'agency_id' => $agency->id,
            'status_id' => $statuses[0]->id,
            'period' => 1
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('draft.approve', $draft->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'This draft is now approved!');
        $this->assertDatabaseHas('drafts', [
            'id' => $draft->id,
            'status_id' => 3
        ]);
    }
    public function test_can_update_draft(): void {
        Storage::fake('public');
        Role::factory()->hrmo()->create();

        $agency = Agency::factory()->create();
        $hrmo = User::factory()->hrmo($agency->id)->create();

        $mechanism = Mechanism::factory()->msp()->create();

        $status = Status::factory()->create();

        
        $draft = Draft::factory()->create([
            'mechanism_id' => $mechanism->id,
            'user_id' => $hrmo->id,
            'agency_id' => NULL,
            'status_id' => $status->id,
            'file_name' => 'old-draft.pdf',
            'file_path' => 'drafts/old-draft.pdf',
            'period' => 1
        ]); 

        Storage::disk('public')->put($draft->file_path, '');
        Storage::disk('public')->assertExists('drafts/old-draft.pdf');

        $response = $this->actingAs($hrmo)
            ->patch(route('draft.update', $draft->id), [
                'file' => UploadedFile::fake()->create(
                    'new-draft.pdf',
                    100,
                    'application/pdf'
                )
            ]);
        
        $response->assertRedirect();
        $response->assertSessionHas(
            'success',
            'Draft file replaced successfully.'
        );

        $this->assertDatabaseHas('drafts', [
            'id' => $draft->id,
            'file_name' => 'new-draft.pdf'
        ]);

        Storage::disk('public')->assertMissing('drafts/old-draft.pdf');

    }
}
