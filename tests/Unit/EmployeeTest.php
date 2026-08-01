<?php

namespace Tests\Unit;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    private function createCenter()
    {
        return \App\Models\Center::create([
            'name' => 'مرکز سلامت تست',
            'code' => 'TEST001',
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

    public function test_can_create_employee(): void
    {
        $center = $this->createCenter();

        $employee = Employee::create([
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
        ]);

        $this->assertDatabaseHas('employees', [
            'personnel_code' => 'EMP001',
            'first_name' => 'علی',
        ]);
    }

    public function test_employee_has_center(): void
    {
        $center = $this->createCenter();

        $employee = Employee::create([
            'personnel_code' => 'EMP002',
            'first_name' => 'محمد',
            'last_name' => 'رضایی',
            'national_code' => '12345678902',
            'birth_date' => '1985-05-15',
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
        ]);

        $this->assertNotNull($employee->center);
        $this->assertSame($center->id, $employee->center_id);
    }

    public function test_employee_soft_delete(): void
    {
        $center = $this->createCenter();

        $employee = Employee::create([
            'personnel_code' => 'EMP003',
            'first_name' => 'رضا',
            'last_name' => 'کریمی',
            'national_code' => '12345678903',
            'birth_date' => '1992-08-20',
            'gender' => 'mard',
            'marital_status' => 'motahel',
            'job_title' => 'مهندس',
            'position' => 'کارشناس IT',
            'employment_type' => 'rasmi',
            'employment_date' => '2021-06-01',
            'center_id' => $center->id,
            'department' => 'فناوری اطلاعات',
            'service_type' => 'fani',
            'status' => 'faal',
            'education_degree' => 'karshenaasi',
            'mobile' => '09123456781',
        ]);
        $employeeId = $employee->id;

        $employee->delete();

        $this->assertSoftDeleted('employees', ['id' => $employeeId]);
    }
}
