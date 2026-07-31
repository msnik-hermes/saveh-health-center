<?php

namespace Tests\Feature;

class CompanyControllerTest extends TestCase
{
    public function test_companies_controller_index() {
        $response = $this->get('/companies');
        $response->assertStatus(200);
    }

    public function test_companies_controller_show() {
        $company = $this->createCompany();
        $response = $this->get("/companies/{$company->id}");
        $response->assertStatus(200);
    }

    public function test_companies_controller_store() {
        $data = [
            'name' => 'تست شرکت',
            'status' => 'faal',
            'phone' => '09123456789',
            'email' => 'test@example.com',
        ];

        $response = $this->post('/companies', $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('companies', $data);
    }

    public function test_companies_controller_update() {
        $company = $this->createCompany();

        $response = $this->put("/companies/{$company->id}", [
            'name' => 'تست شرکت بروزرسانی',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'تست شرکت بروزرسانی',
        ]);
    }

    public function test_companies_controller_destroy() {
        $company = $this->createCompany();
        $companyId = $company->id;

        $response = $this->delete("/companies/{$companyId}");
        $response->assertStatus(302);

        $this->assertSoftDeleted('companies', ['id' => $companyId]);
    }

    protected function createCompany() {
        return $this->company = \App\Models\Company::create([
            'name' => 'تست شرکت',
            'status' => 'faal',
            'phone' => '09123456789',
            'email' => 'test@example.com',
        ]);
    }
}
