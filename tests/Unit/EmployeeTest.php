<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\User;
use App\Models\OrganizationalUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_employee(): void
    {
        $user = User::factory()->create();
        $unit = OrganizationalUnit::factory()->create();

        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'position' => 'پزشک',
            'employment_status' => 'active',
        ]);

        $this->assertDatabaseHas('employees', [
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'position' => 'پزشک',
        ]);
    }

    public function test_employee_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $employee->user);
        $this->assertSame($user->id, $employee->user->id);
    }

    public function test_employee_belongs_to_organizational_unit(): void
    {
        $unit = OrganizationalUnit::factory()->create();
        $employee = Employee::factory()->create(['unit_id' => $unit->id]);

        $this->assertInstanceOf(OrganizationalUnit::class, $employee->unit);
        $this->assertSame($unit->id, $employee->unit->id);
    }

    public function test_employee_employment_status_validation(): void
    {
        $employee = Employee::factory()->create(['employment_status' => 'active']);
        $this->assertSame('active', $employee->employment_status);

        $employee->update(['employment_status' => 'inactive']);
        $this->assertSame('inactive', $employee->fresh()->employment_status);
    }

    public function test_employee_soft_delete(): void
    {
        $employee = Employee::factory()->create();
        $employeeId = $employee->id;

        $employee->delete();

        $this->assertSoftDeleted('employees', ['id' => $employeeId]);
        $this->assertNotNull(Employee::onlyTrashed()->find($employeeId));
    }
}