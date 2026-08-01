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
            'display_name' => 'مدیر سیستم',
            'description' => 'مدیر سیستم با دسترسی کامل',
        ];

        $role = Role::create($data);

        $this->assertDatabaseHas('roles', ['name' => 'مدیر']);
        $this->assertNotNull($role->id);
        $this->assertSame('مدیر', $role->name);
    }

    public function test_role_requires_name(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        Role::create(['display_name' => 'test']);
    }

    public function test_role_unique_name(): void
    {
        Role::create(['name' => 'کارمند', 'display_name' => 'Staff']);

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);
        Role::create(['name' => 'کارمند', 'display_name' => 'Staff2']);
    }

    public function test_role_has_display_name(): void
    {
        $role = Role::create([
            'name' => 'admin',
            'display_name' => 'مدیر سیستم',
        ]);

        $this->assertSame('مدیر سیستم', $role->display_name);
    }
}
