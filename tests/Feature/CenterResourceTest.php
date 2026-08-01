<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CenterResourceTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsAdmin(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin2@test.com',
            'password' => 'password',
        ]);
        $this->actingAs($user);
    }

    public function test_center_resource_index(): void
    {
        $this->loginAsAdmin();
        $response = $this->get('/admin/centers');
        $response->assertStatus(200);
    }

    public function test_center_resource_create_page(): void
    {
        $this->loginAsAdmin();
        $response = $this->get('/admin/centers/create');
        $response->assertStatus(200);
    }
}
