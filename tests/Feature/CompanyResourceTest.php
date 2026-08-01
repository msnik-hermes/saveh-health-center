<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyResourceTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsAdmin(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);
        $this->actingAs($user);
    }

    public function test_company_resource_index(): void
    {
        $this->loginAsAdmin();
        $response = $this->get('/admin/companies');
        $response->assertStatus(200);
    }

    public function test_company_resource_create_page(): void
    {
        $this->loginAsAdmin();
        $response = $this->get('/admin/companies/create');
        $response->assertStatus(200);
    }

    public function test_company_resource_edit_page(): void
    {
        $this->loginAsAdmin();
        $company = \App\Models\Company::create([
            'name' => 'Test Company',
            'status' => 'active',
        ]);
        $response = $this->get('/admin/companies/' . $company->id . '/edit');
        $response->assertStatus(200);
    }
}
