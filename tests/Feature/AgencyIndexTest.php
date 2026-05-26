<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\FieldOffice;
use App\Models\Mechanism;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AgencyIndexTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_agencies_index(): void {
        Role::factory()->administrator()->create();
        $admin = User::factory()->administrator()->create();
        $fieldOffice = FieldOffice::factory()->create();
        Agency::factory()->create([
            'name' => 'Civil Service Commission',
            'field_office_id' => $fieldOffice->id,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('agencies.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.agencies');
        $response->assertViewHas('agencies');
        $response->assertViewHas('fieldOffices');
    }


    public function test_can_store_agency(): void {
        Storage::fake('public');
        Role::factory()->administrator()->create();
        $admin = User::factory()->administrator()->create();
        $fieldOffice = FieldOffice::factory()->create();
        Mechanism::factory()->msp()->create();
        Mechanism::factory()->spms()->create();

        $response = $this->actingAs($admin)
            ->post(route('agency.store'), [
                'name' => 'Civil Service Commission',
                'abbreviation' => 'CSC',
                'head' => 'Juan Dela Cruz',
                'email_address' => 'csc@gmail.com',
                'field_office_id' => $fieldOffice->id,

                'photo' => UploadedFile::fake()->image('agency.jpg'),
            ]);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Agency added successfully');

        $this->assertDatabaseHas('agencies', [
            'name' => 'Civil Service Commission',
            'abbreviation' => 'CSC',
            'email_address' => 'csc@gmail.com',
        ]);
        $this->assertDatabaseHas('agency_mechanism_periods', [
            'agency_id' => 1,
            'mechanism_id' => 1,
            'current_period' => 1,
        ]);
        $this->assertDatabaseHas('agency_mechanism_periods', [
            'agency_id' => 1,
            'mechanism_id' => 2,
            'current_period' => 1,
        ]);
    }

    public function test_can_view_agency_data(): void {
        Role::factory()->administrator()->create();
        Role::factory()->hrmo()->create();
        $admin = User::factory()->administrator()->create();
        $fieldOffice = FieldOffice::factory()->create();

        $agency = Agency::factory()->create([
            'field_office_id' => $fieldOffice->id,
        ]);

        User::factory()->hrmo($agency->id)->create();
        $msp = Mechanism::factory()->msp()->create();

        AgencyMechanismPeriod::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $msp->id,
            'current_period' => 1,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('agency.show', $agency));

        $response->assertStatus(200);
        $response->assertViewIs('admin.agency');
        $response->assertViewHas('agency');
        $response->assertViewHas('fieldOffices');
        $response->assertViewHas('drafts');
        $response->assertViewHas('approvedCount');
        $response->assertViewHas('agency_hrmo');
    }

    public function test_can_update_agency(): void{
        Storage::fake('public');
        Role::factory()->administrator()->create();
        $admin = User::factory()->administrator()->create();
        $fieldOffice = FieldOffice::factory()->create();
        $agency = Agency::factory()->create([
            'name' => 'Old Agency',
            'abbreviation' => 'OLD',
            'field_office_id' => $fieldOffice->id,
            'email_address' => 'old@gmail.com',
            'head' => 'Old Head',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('agency.update', $agency), [
                'name' => 'New Agency',
                'abbreviation' => 'NEW',
                'field_office_id' => $fieldOffice->id,
                'email_address' => 'new@gmail.com',
                'head' => 'New Head',

                'photo' => UploadedFile::fake()->image('new-photo.jpg'),
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Agency updated successfully!');
        $this->assertDatabaseHas('agencies', [
            'id' => $agency->id,
            'name' => 'New Agency',
            'abbreviation' => 'NEW',
            'email_address' => 'new@gmail.com',
            'head' => 'New Head',
        ]);
    }

}
