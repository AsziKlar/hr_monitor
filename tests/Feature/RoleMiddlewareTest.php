<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;
    // FAILING test for rolemiddleware
    public function test_role_mismatch_be_forbidden(): void
    {
        $roleHRMO = Role::create(['name'=>'HRMO']);

        $user = User::factory()->create([
            'role_id' => $roleHRMO->id,
            'email_verified_at' => now()
        ]);
        

        $response = $this->actingAs($user)->get('/admin/dashboard');
        // dump($response->headers->get('Location'));
        $response->assertForbidden();
    }
}
