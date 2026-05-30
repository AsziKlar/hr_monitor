<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    
    use RefreshDatabase;

    public function test_admin_user_cannot_login(): void {
        Role::factory()->administrator()->create();
        $user = User::factory()->administrator()->create([
            'password' => 'password'
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_no_agency(): void {
        $agency = Agency::factory()->create();
        Role::factory()->hrmo()->create();
        $user = User::factory()->hrmo($agency->id)->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $agency->delete();

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
    public function test_user_archive_agency(): void {
        $agency = Agency::factory()->create([
            'archived_at' => now()
        ]);
        Role::factory()->hrmo()->create();
        $user = User::factory()->hrmo($agency->id)->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

     public function test_user_hrmo_can_login(): void {
        $agency = Agency::factory()->create();
        Role::factory()->hrmo()->create();
        $user = User::factory()->hrmo($agency->id)->create([
            'password' => bcrypt('1234')
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => '1234',
        ]);

        $response->assertRedirect(route('hrmo.dashboard'));
        $this->assertAuthenticated();
    }
    

    public function test_admin_user_can_login(): void
    {
        Role::factory()->administrator()->create();
        $user = User::factory()->administrator()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }
    public function test_admin_can_logout(){
        Role::factory()->administrator()->create();
        $admin = User::factory()->administrator()->create();

        $response = $this->actingAs($admin)
            ->post(route('logout'));

        $response->assertRedirect('login');
        $this->assertGuest(); 
    }
}
