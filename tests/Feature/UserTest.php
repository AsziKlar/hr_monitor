<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_index(): void
    {
        Role::factory()->administrator()->create();
        $admin = User::factory()->administrator()->create();
        Agency::factory()->count(2)->create();


        $activeUser1 = User::factory()->create([
            'name' => 'Klarissa Vasallo'
        ]);
        $activeUser2 = User::factory()->create([
            'name' => 'Irah Vasallo'
        ]);

        $users = User::all();

        $this->assertCount(3, $users);

        User::where('name', 'Irah Vasallo')
            ->update([
                'archived_at' => now()
            ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.account.index', [
                'search' => 'Vasallo'
            ]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.account-management');
        $response->assertViewHas('users');
        $response->assertViewHas('agencies');
        $response->assertViewHas('roles');

        $response->assertSee('Klarissa Vasallo');

        $response->assertDontSee($activeUser2->name);
        $response->assertViewHas('users', function ($users) {
            return $users->count() === 1;
        });
         $this->assertCount(3, $users);
        
    }

    public function test_admin_can_create_hrmo_user_account(): void {
        Role::factory()->administrator()->create();
        Role::factory()->processor()->create();
        Role::factory()->reviewer()->create();

        $admin = User::factory()->administrator()->create();

        Role::factory()->hrmo()->create();

        $agency = Agency::factory()->create();

        $response = $this->actingAs($admin)
            ->from(route('admin.account.index'))
            ->post(route('admin.account.store'), [
                'name' => 'Klarissa Vasallo',
                'email' => 'klarissa@example.com',
                'role' => 4,
                'agency' => $agency->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas(
            'success',
            'Successfully created a new user account!'
        );

        $this->assertDatabaseHas('users', [
            'name' => 'Klarissa Vasallo',
            'email' => 'klarissa@example.com',
            'role_id' => 4,
            'agency_id' => $agency->id,
        ]);
    }
    public function test_admin_can_archive_user_account(): void{
        Role::factory()->administrator()->create();

        $admin = User::factory()->administrator()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($admin)
            ->patch(route('admin.accounts.archive', $user));

        $response->assertRedirect();

        $response->assertSessionHas(
            'success',
            'Account archived successfully'
        );

        $this->assertNotNull(
            $user->fresh()->archived_at
        );
    }

    public function test_hrmo_can_update_own_account(): void{
        Role::factory()->hrmo()->create();
        $agency = Agency::factory()->create();
        $user = User::factory()->hrmo($agency->id)->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'password' => 'oldpassword',
        ]);

        $response = $this->actingAs($user)
            ->patch(route('hrmo.account.update'), [
                'name' => 'Jessica Vasallo',
                'email' => 'jessica@mail.com',
                'password' => 'newpassword',
            ]);

        $response->assertRedirect();

        $response->assertSessionHas(
            'success',
            'Account updated successfully'
        );

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jessica Vasallo',
            'email' => 'jessica@mail.com',
        ]);
    }


}
