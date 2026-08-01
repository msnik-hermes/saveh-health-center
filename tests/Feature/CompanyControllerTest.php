<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_companies_index(): void
    {
        $response = $this->getJson('/api/companies');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_companies_show(): void
    {
        $company = $this->createCompany();
        $response = $this->getJson("/api/companies/{$company->id}");
        $response->assertStatus(200);
        $response->assertJson(['data' => ['name' => 'تست شرکت']]);
    }

    public function test_companies_store(): void
    {
        $data = ['name' => 'شرکت جدید', 'status' => 'active'];

        $response = $this->postJson('/api/companies', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('companies', ['name' => 'شرکت جدید']);
    }

    public function test_companies_store_requires_name(): void
    {
        $response = $this->postJson('/api/companies', []);
        $response->assertStatus(422);
    }

    public function test_companies_update(): void
    {
        $company = $this->createCompany();

        $response = $this->putJson("/api/companies/{$company->id}", [
            'name' => 'شرکت بروزرسانی',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'شرکت بروزرسانی',
        ]);
    }

    public function test_companies_destroy(): void
    {
        $company = $this->createCompany();
        $companyId = $company->id;

        $response = $this->deleteJson("/api/companies/{$companyId}");
        $response->assertStatus(200);
        $this->assertSoftDeleted('companies', ['id' => $companyId]);
    }

    protected function createCompany()
    {
        return \App\Models\Company::create([
            'name' => 'تست شرکت',
            'status' => 'active',
        ]);
    }
}
