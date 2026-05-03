<?php

namespace Tests\Unit;

use App\Models\AgencyMechanismPeriod;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Mockery;
use App\Models\Draft;
use App\Models\Role;
use App\Models\User;

class DraftTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_non_hrmo_should_view_all_regardless_of_agency(){
        $role = new Role(['name' => 'Admin']);

        $user = new User(['agency_id' => 1]);

        $user->setRelation('role', $role);

        $shouldFilterByAgency = $user->role->name === 'HRMO';

        $this->assertFalse($shouldFilterByAgency);
    }

    public function test_hrmo_should_filter_by_agency(){
        $role = new Role(['name'=>'HRMO']);

        $user = new User(['agency_id' => 1]);

        $user->setRelation('role', $role);

        $shouldFilterByAgency = $user->role->name === 'HRMO';

        $this->assertTrue($shouldFilterByAgency);

    }


    public function test_file_is_required_false(): void{

        $validator = Validator::make(
            ['file' =>null],
            ['file' => 'required|file|mimes:pdf|max:10240']
        );

        $this->assertFalse($validator->passes());
    }

    public function test_file_is_required_true(): void{
          $file = UploadedFile::fake()->create('document.pdf',100);
        $validator = Validator::make(
            ['file' => $file],
            ['file' => 'required|file|mimes:pdf|max:10240']
        );

        $this->assertTrue($validator->passes());
    }



    public function test_pdf_file_is_valid(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $validator = Validator::make(
            ['file' => $file],
            ['file' => 'required|file|mimes:pdf|max:10240'],
        );

        $this->assertTrue($validator->passes());
    }

}
