<?php

namespace Tests\Feature;

use App\Http\Controllers\DraftController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Agency;
use App\Models\AgencyMechanismPeriod;
use App\Models\Mechanism;
use App\Models\Draft;
use App\Models\FieldOffice;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Status;
use Database\Factories\MechanismFactory;
use Database\Factories\AgencyFactory;
use Database\Factories\DraftFactory;

class DraftTest extends TestCase
{
    
    use RefreshDatabase;

    //---------  FAILING test for DraftController store() ----------------
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
    
//------------    PASSING test for DraftController store() ------------
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

        // $response->dumpSession();
                    
        $response->assertRedirect(route('drafts.index'));

        $response->assertSessionHas(
            'success',
            'Draft submitted successfully!'
        );

    }
    
    //---------FAILING test for DraftController index()-----------

    public function test_draft_and_user_agency_mismatch() {
        $role = Role::create([
            'name' => 'HRMO'
        ]);

        $agency = Agency::create([
            'name' => 'XU',
            'email_address' => 'xu@mail.com'
        ]);

        $otherAgency = Agency::create([
            'name' => 'LDCU',
            'email_address' => 'ldcu@mail.com'
        ]);

        $user = User::create([
            'name' => 'Christina',
            'email' =>'christina@mail.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
            'agency_id' => $agency->id
        ]);

        $mechanism = Mechanism::create([
            'name' => 'MSP',
            'is_active' => true
        ]);

        $draft = Draft::create([
            'agency_id' => $otherAgency->id,
            'mechanism_id' => $mechanism->id,
            'file_name'=>'sample.pdf',
            'file_path' => 'drafts/sample.pdf'
        ]);

        $searchDrafts = Draft::where('agency_id', $user->agency_id)
                            ->where('mechanism_id', $mechanism->id)
                            ->get();

    
        $this->assertFalse($searchDrafts->contains($draft));
    }

    //----------PASSING test for DraftController index()--------------
    public function test_draft_and_user_agency_matched() {
        $role = Role::create([
            'name' => 'HRMO'
        ]);

        $agency = Agency::create([
            'name' => 'XU',
            'email_address' => 'xu@mail.com'
        ]);

        $otherAgency = Agency::create([
            'name' => 'LDCU',
            'email_address' => 'ldcu@mail.com'
        ]);

        $user = User::create([
            'name' => 'Christina',
            'email' =>'christina@mail.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
            'agency_id' => $agency->id
        ]);

        $mechanism = Mechanism::create([
            'name' => 'MSP',
            'is_active' => true
        ]);

        $draft = Draft::create([
            'agency_id' => $agency->id,
            'mechanism_id' => $mechanism->id,
            'file_name'=>'sample.pdf',
            'file_path' => 'drafts/sample.pdf'
        ]);

        $searchDrafts = Draft::where('agency_id', $user->agency_id)
                            ->where('mechanism_id', $mechanism->id)
                            ->get();


        // dd($searchDrafts->toArray());

        $this->assertTrue($searchDrafts->contains('id', $draft->id));
    }

    //-------------FAILING test for DraftController show()-------------
    public function test_fail_where_query_cannot_be_found(){
        $role = Role::create([
            'name' => 'HRMO',
        ]);
        $agency = Agency::factory()->create();
       
        $mechanism = Mechanism::factory()->create();

        $draft = Draft::factory()->count(2)->create();

        $searchDrafts = Draft::find(3);

        $this->assertNull($searchDrafts);
    }
    
    //PASSING test for DraftController show()
    public function test_passing_where_query_is_found(){
        $role = Role::create(['name'=>'HRMO']);

        $agency = Agency::factory()->create();

        $mechnanism = Mechanism::factory()->create();

        $draft = Draft::factory()->count(1)->create();

        $searchDrafts = Draft::find(1);
        
        $this->assertNotNull($searchDrafts);
    }

    public function test_refactor_where_query_is_found_with_status(){
        $role = Role::create(['name'=>'HRMO']);
        $status = Status::factory()->create();
        $agency = Agency::factory()->create();
        $mechanism = Mechanism::factory()->create();
        $draft = Draft::factory()->create(['status_id' => $status->id]);
        
        $searchDrafts = Draft::with('status')->find(1);

        $this->assertEquals('To be Reviewed',$searchDrafts->status->name);
    }

    public function failing_test_photo_is_required_when_storing_agency(){
        $role = Role::factory()->create([
        'name' => 'Administrator'
        ]);

        $user = User::factory()->create([
        'role_id' => $role->id
        ]);

        $fieldOffice = FieldOffice::factory()->create();

        $response = $this->actingAs($user)->post(route('agencies.store'), [
        'name' => 'CSC Region X',
        'abbreviation' => 'CSC-X',
        'head' => 'Maria Clara',
        'email_address' => 'cscx@email.com',
        'field_office_id' => $fieldOffice->id,
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function passing_test_admin_can_store_agency(){

        Storage::fake('public');

        $user = User::factory()->create();

        $fieldOffice = FieldOffice::factory()->create();

        $response = $this->actingAs($user)->post(route('agencies.store'), [
        'name' => 'CSC Region X',
        'abbreviation' => 'CSC-X',
        'head' => 'Maria Clara',
        'email_address' => 'csc@email.com',
        'field_office_id' => $fieldOffice->id,
        'photo' => UploadedFile::fake()->image('agency.jpg'),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('agencies', [
        'name' => 'CSC Region X',
        'email_address' => 'csc@email.com',
        ]);
    }

}
