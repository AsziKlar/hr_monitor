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
}
