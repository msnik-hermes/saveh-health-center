<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_belongs_to_many_permissions(): void
    {
        $role = Role::create(['name' => 'admin', 'display_name' => 'مدیر']);
        $permission = Permission::create([
            'name' => 'companies.read',
            'display_name' => 'مشاهده شرکت‌ها',
            'table_name' => 'companies',
            'action' => 'read',
        ]);

        $role->permissions()->attach($permission->id);

        $this->assertCount(1, $role->permissions);
        $this->assertTrue($role->permissions->contains($permission->id));
    }

    public function test_permission_belongs_to_many_roles(): void
    {
        $role = Role::create(['name' => 'editor', 'display_name' => 'ویرایشگر']);
        $permission = Permission::create([
            'name' => 'companies.write',
            'display_name' => 'ویرایش شرکت‌ها',
            'table_name' => 'companies',
            'action' => 'write',
        ]);

        $permission->roles()->attach($role->id);

        $this->assertCount(1, $permission->roles);
        $this->assertTrue($permission->roles->contains($role->id));
    }

    public function test_role_has_many_users(): void
    {
        $role = Role::create(['name' => 'staff', 'display_name' => 'کارمند']);
        $user1 = User::create(['name' => 'کاربر اول', 'email' => uniqid() . '@test.com', 'password' => 'pass']);
        $user2 = User::create(['name' => 'کاربر دوم', 'email' => uniqid() . '@test.com', 'password' => 'pass']);

        $role->users()->attach([$user1->id, $user2->id]);

        $this->assertCount(2, $role->users);
    }

    public function test_user_belongs_to_many_roles(): void
    {
        $user = User::create(['name' => 'تست', 'email' => uniqid() . '@test.com', 'password' => 'pass']);
        $role1 = Role::create(['name' => 'admin', 'display_name' => 'مدیر']);
        $role2 = Role::create(['name' => 'editor', 'display_name' => 'ویرایشگر']);

        $user->roles()->attach([$role1->id, $role2->id]);

        $this->assertCount(2, $user->roles);
    }

    public function test_role_has_pivot_data(): void
    {
        $role = Role::create(['name' => 'supervisor', 'display_name' => 'سرپرست']);
        $permission = Permission::create([
            'name' => 'employees.manage',
            'display_name' => 'مدیریت کارکنان',
            'table_name' => 'employees',
            'action' => 'manage',
        ]);

        $role->permissions()->attach($permission->id);

        $this->assertNotNull($role->permissions->first()->pivot);
        $this->assertEquals($role->id, $role->permissions->first()->pivot->role_id);
        $this->assertEquals($permission->id, $role->permissions->first()->pivot->permission_id);
    }

    public function test_user_permission_relationship(): void
    {
        $user = User::create(['name' => 'تست', 'email' => uniqid() . '@test.com', 'password' => 'pass']);
        $permission = Permission::create([
            'name' => 'reports.view',
            'display_name' => 'مشاهده گزارش‌ها',
            'table_name' => 'reports',
            'action' => 'view',
        ]);
        $admin = User::create(['name' => 'ادمین', 'email' => uniqid() . '@test.com', 'password' => 'pass']);

        $userPermission = \App\Models\UserPermission::create([
            'user_id' => $user->id,
            'permission_id' => $permission->id,
            'is_granted' => true,
            'granted_by' => $admin->id,
        ]);

        $this->assertNotNull($userPermission);
        $this->assertEquals($user->id, $userPermission->user->id);
        $this->assertEquals($permission->id, $userPermission->permission->id);
    }

    public function test_company_has_many_inspections(): void
    {
        $company = Company::create(['name' => 'شرکت تست', 'status' => 'active']);

        $this->assertIsIterable($company->companyInspections);
        $this->assertCount(0, $company->companyInspections);
    }

    public function test_company_has_many_hazard_assessments(): void
    {
        $company = Company::create(['name' => 'شرکت تست', 'status' => 'active']);

        $this->assertIsIterable($company->hazardAssessments);
        $this->assertCount(0, $company->hazardAssessments);
    }

    public function test_center_has_many_employees(): void
    {
        $center = \App\Models\Center::create([
            'name' => 'مرکز تست',
            'code' => uniqid('C_'),
            'type' => 'hospital',
            'university' => 'دانشگاه',
            'province' => 'تهران',
            'city' => 'تهران',
            'address' => 'آدرس',
            'status' => 'active',
        ]);

        $this->assertIsIterable($center->employees);
    }

    public function test_employee_belongs_to_center(): void
    {
        $center = \App\Models\Center::create([
            'name' => 'مرکز تست',
            'code' => uniqid('C_'),
            'type' => 'hospital',
            'university' => 'دانشگاه',
            'province' => 'تهران',
            'city' => 'تهران',
            'address' => 'آدرس',
            'status' => 'active',
        ]);

        $employee = Employee::create([
            'personnel_code' => 'REL001',
            'first_name' => 'تست',
            'last_name' => 'رابطه',
            'national_code' => '12345678901',
            'birth_date' => '1990-01-01',
            'gender' => 'mard',
            'marital_status' => 'motahel',
            'job_title' => 'تست',
            'position' => 'تست',
            'employment_type' => 'rasmi',
            'employment_date' => '2020-01-01',
            'center_id' => $center->id,
            'department' => 'تست',
            'service_type' => 'darmani',
            'status' => 'faal',
            'education_degree' => 'test',
            'mobile' => '09123456789',
        ]);

        $this->assertNotNull($employee->center);
        $this->assertEquals($center->id, $employee->center->id);
    }
}
