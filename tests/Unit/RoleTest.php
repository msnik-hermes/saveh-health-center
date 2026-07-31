<?php

namespace Tests\Unit;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_role_with_valid_data(): void
    {
        $data = [
            'name' => 'مدیر',
            'level' => 1,
            'description' => 'مدیر سیستم با دسترسی کامل',
        ];

        $role = Role::create($data);

        $this->assertDatabaseHas('roles', $data);
        $this->assertNotNull($role->id);
        $this->assertSame($data['name'], $role->name);
    }

    public function test_role_requires_name(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        Role::create(['level' => 1]);
    }

    public function test_role_level_validation(): void
    {
        $role = Role::create([
            'name' => 'کارمند',
            'level' => 3,
            'description' => 'کارمند با دسترسی متوسط',
        ]);

        $this->assertDatabaseHas('roles', ['level' => 3]);
        $this->assertSame(3, $role->level);
    }

    public function test_role_unique_name(): void
    {
        Role::create(['name' => 'کارمند واحد', 'level' => 2]);

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);
        Role::create(['name' => 'کارمند واحد', 'level' => 4]);
    }

    public function test_role_relationships(): void
    {
        $role = Role::create(['name' => 'مدیر', 'level' => 1]);

        $this->assertHasExactCount(0, $role->users());
        $this->assertHasExactCount(0, $role->permissions());
    }

    public function test_role_permissions(): void
    {
        $role = Role::create(['name' => 'مدیر', 'level' => 1]);

        $permissionData = [
            'role_id' => $role->id,
            'resource' => 'companies',
            'action' => 'read',
            'description' => 'دسترسی به اطلاعات شرکت‌ها',
        ];

        $permission = $role->permissions()->create($permissionData);

        $this->assertDatabaseHas('role_permissions', $permissionData);
        $this->assertSame($role->id, $permission->role_id);
    }
}