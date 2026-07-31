<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_valid_data(): void
    {
        $data = [
            'employee_id' => 'EMP001',
            'name' => 'حسین احمدی',
            'email' => 'h.ahmedi@example.com',
            'password' => 'password123',
            'center_id' => 1,
            'is_active' => true,
        ];

        $user = User::create($data);

        $this->assertDatabaseHas('users', $data);
        $this->assertNotNull($user->id);
        $this->assertSame($data['name'], $user->name);
        $this->assertTrue($user->is_active);
    }

    public function test_user_email_is_required(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        User::create(['name' => 'کاربر', 'password' => 'password']);
    }

    public function test_user_password_is_hashed(): void
    {
        $user = User::create([
            'name' => 'کاربر',
            'email' => 'test@example.com',
            'password' => 'plainpassword',
        ]);

        $this->assertNotSame('plainpassword', $user->password);
        $this->assertTrue(password_verify('plainpassword', $user->password));
    }

    public function test_user_has_role_relationship(): void
    {
        $user = User::factory()->create();
        $role = $user->roles()->create([
            'name' => 'مدیر',
            'level' => 1,
            'description' => 'مدیر سیستم',
        ]);

        $this->assertInstanceOf(\App\Models\Role::class, $user->roles()->first());
        $this->assertSame($role->id, $user->roles()->first()->id);
    }

    public function test_user_has_center_relationship(): void
    {
        $user = User::factory()->create(['center_id' => 1]);

        $this->assertInstanceOf(\App\Models\Center::class, $user->center);
        $this->assertSame(1, $user->center->id);
    }

    public function test_user_has_activity_logs(): void
    {
        $user = User::factory()->create();
        $log = $user->activityLogs()->create([
            'action' => 'login',
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Chrome',
        ]);

        $this->assertCount(1, $user->activityLogs);
        $this->assertSame($log->id, $user->activityLogs()->first()->id);
    }

    public function test_user_has_role_method(): void
    {
        $user = User::factory()->create();
        $role = $user->roles()->create(['name' => 'مدیر', 'level' => 1]);

        $this->assertTrue($user->hasRole('مدیر'));
        $this->assertFalse($user->hasRole('کارمند'));
    }
}