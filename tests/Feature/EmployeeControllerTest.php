<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createCenter()
    {
        return \App\Models\Center::create([
            'name' => 'مرکز سلامت تست',
            'code' => uniqid('CTR_'),
            'type' => 'hospital',
            'university' => 'دانشگاه علوم پزشکی',
            'province' => 'تهران',
            'city' => 'تهران',
            'address' => 'آدرس تست',
            'phone' => '09123456789',
            'email' => 'test@center.com',
            'status' => 'active',
        ]);
    }

    private function createEmployee(array $overrides = [])
    {
        $center = $this->createCenter();
        return Employee::create(array_merge([
            'personnel_code' => 'EMP001',
            'first_name' => 'علی',
            'last_name' => 'احمدی',
            'national_code' => '12345678901',
            'birth_date' => '1990-01-01',
            'gender' => 'mard',
            'marital_status' => 'motahel',
            'job_title' => 'پزشک',
            'position' => 'پزشک عمومی',
            'employment_type' => 'rasmi',
            'employment_date' => '2020-01-01',
            'center_id' => $center->id,
            'department' => 'درمان',
            'service_type' => 'darmani',
            'status' => 'faal',
            'education_degree' => 'doctora',
            'mobile' => '09123456789',
        ], $overrides));
    }

    public function test_index(): void
    {
        $response = $this->getJson('/api/employees');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    public function test_index_filter_by_center(): void
    {
        $center = $this->createCenter();
        Employee::create([
            'personnel_code' => 'EMP010',
            'first_name' => 'رضا',
            'last_name' => 'کریمی',
            'national_code' => '9999999999',
            'birth_date' => '1985-01-01',
            'gender' => 'mard',
            'marital_status' => 'motahel',
            'job_title' => 'مهندس',
            'position' => 'کارشناس',
            'employment_type' => 'rasmi',
            'employment_date' => '2019-01-01',
            'center_id' => $center->id,
            'department' => 'IT',
            'service_type' => 'fani',
            'status' => 'faal',
            'education_degree' => 'karshenaasi',
            'mobile' => '09120000000',
        ]);

        $response = $this->getJson("/api/employees?center_id={$center->id}");
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_index_search(): void
    {
        $this->createEmployee(['personnel_code' => 'SEARCH01', 'first_name' => 'امیر']);
        $this->createEmployee(['personnel_code' => 'SEARCH02', 'first_name' => 'حسین']);

        $response = $this->getJson('/api/employees?search=امیر');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_show(): void
    {
        $employee = $this->createEmployee();

        $response = $this->getJson("/api/employees/{$employee->id}");
        $response->assertStatus(200);
        $response->assertJson(['data' => ['first_name' => 'علی']]);
    }

    public function test_store(): void
    {
        $center = $this->createCenter();

        $data = [
            'personnel_code' => 'NEW001',
            'first_name' => 'محمد',
            'last_name' => 'رضایی',
            'national_code' => '1111111111',
            'birth_date' => '1988-05-15',
            'gender' => 'mard',
            'marital_status' => 'motahel',
            'job_title' => 'پرستار',
            'position' => 'پرستار بخش',
            'employment_type' => 'rasmi',
            'employment_date' => '2018-03-01',
            'center_id' => $center->id,
            'department' => 'پرستاری',
            'service_type' => 'darmani',
            'status' => 'faal',
            'education_degree' => 'karshenaasi',
            'mobile' => '09123456780',
        ];

        $response = $this->postJson('/api/employees', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('employees', ['personnel_code' => 'NEW001']);
    }

    public function test_store_requires_fields(): void
    {
        $response = $this->postJson('/api/employees', []);
        $response->assertStatus(422);
    }

    public function test_store_duplicate_personnel_code(): void
    {
        $center = $this->createCenter();
        $this->createEmployee(['center_id' => $center->id]);

        $data = [
            'personnel_code' => 'EMP001',
            'first_name' => 'محمد',
            'last_name' => 'رضایی',
            'national_code' => '2222222222',
            'birth_date' => '1988-05-15',
            'gender' => 'mard',
            'marital_status' => 'motahel',
            'job_title' => 'پرستار',
            'position' => 'پرستار بخش',
            'employment_type' => 'rasmi',
            'employment_date' => '2018-03-01',
            'center_id' => $center->id,
            'department' => 'پرستاری',
            'service_type' => 'darmani',
            'status' => 'faal',
            'education_degree' => 'karshenaasi',
            'mobile' => '09123456780',
        ];

        $response = $this->postJson('/api/employees', $data);
        $response->assertStatus(422);
    }

    public function test_update(): void
    {
        $employee = $this->createEmployee();

        $response = $this->putJson("/api/employees/{$employee->id}", [
            'first_name' => 'امیر',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'first_name' => 'امیر',
        ]);
    }

    public function test_destroy(): void
    {
        $employee = $this->createEmployee();
        $empId = $employee->id;

        $response = $this->deleteJson("/api/employees/{$empId}");
        $response->assertStatus(200);
        $this->assertSoftDeleted('employees', ['id' => $empId]);
    }
}
