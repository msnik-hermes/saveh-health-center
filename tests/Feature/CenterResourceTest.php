<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Center;
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

    public function test_center_resource_edit_page(): void
    {
        $this->loginAsAdmin();
        $center = Center::create([
            'name' => 'Test Center',
            'code' => uniqid('CTR_'),
            'type' => 'hospital',
            'university' => 'Test University',
            'province' => 'Tehran',
            'city' => 'Tehran',
            'address' => 'Test Address',
            'status' => 'active',
        ]);
        $response = $this->get('/admin/centers/' . $center->id . '/edit');
        $response->assertStatus(200);
    }
}
