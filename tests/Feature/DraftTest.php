<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\Mechanism;
use App\Models\FieldOffice;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Status;


class DraftTest extends TestCase
{
    
    use RefreshDatabase;

    public function test_error_when_no_period(){
        Storage::fake('public');

        $role = Role::create([ 'name' => 'HRMO']);

        $fieldOffice = FieldOffice::create([
            'name' => 'Region X',
        ]);

        $agency = Agency::create([
            'name' => 'Department of Health',
            'email_address' => 'doh@mail.com',
            'field_office_id' => $fieldOffice->id
        ]);


        $user = User::factory()->create([
            'role_id' => $role->id,
            'agency_id' => $agency->id
        ]);

        $mechanism = Mechanism::create([
            'name' => 'Merit Selection Plan',
            'is_active' => true
        ]);

        $response = $this->actingAs($user)
                    ->from('/drafts/create')
                    ->post('/drafts', [
                        'mechanism_id' => $mechanism->id,
                        'file' => UploadedFile::fake()->create('draft.pdf', 100)
                    ]);

        $response->assertRedirect('/drafts/create');

        $response->assertSessionHas(
            'error',
            'No period has been opened for this mechanism yet.'
        );

    }
    
   public function test_passes_with_period(){
        Storage::fake('public');

        $role = Role::create([ 'name' => 'HRMO']);

        $fieldOffice = FieldOffice::create([
            'name' => 'Region X',
        ]);

        $agency = Agency::create([
            'name' => 'Department of Health',
            'email_address' => 'doh@mail.com',
            'field_office_id' => $fieldOffice->id
        ]);


        $user = User::factory()->create([
            'role_id' => $role->id,
            'agency_id' => $agency->id
        ]);

        $mechanism = Mechanism::create([
            'name' => 'Merit Selection Plan',
            'is_active' => true
        ]);

        $period = AgencyMechanismPeriod::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'current_period' => 1
        ]);

        Status::create([
            'name' => 'To be Reviewed',
        ]);

        $response = $this->actingAs($user)
                    ->from('/drafts/create')
                    ->post('/drafts', [
                        'mechanism_id' => $mechanism->id,
                        'file' => UploadedFile::fake()->create('draft.pdf', 100, 'application/pdf')
                    ]);

        //$response->dumpSession();
                    
        $response->assertRedirect(route('drafts.index'));

        $response->assertSessionHas(
            'success',
            'Draft submitted successfully!'
        );

    }


}
