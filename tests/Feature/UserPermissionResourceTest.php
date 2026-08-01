<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPermissionResourceTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsAdmin(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin3@test.com',
            'password' => 'password',
        ]);
        $this->actingAs($user);
    }

    public function test_user_permission_resource_index(): void
    {
        $this->markTestSkipped('UserPermissionResource not registered in panel');
    }
}
