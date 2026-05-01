<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class DraftTest extends TestCase
{
    /**
     * A basic unit test example.
     */

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
