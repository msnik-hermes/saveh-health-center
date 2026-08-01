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
            'name' => 'حسین احمدی',
            'email' => 'h.ahmedi@example.com',
            'password' => 'password123',
        ];

        $user = User::create($data);

        $this->assertDatabaseHas('users', ['email' => 'h.ahmedi@example.com']);
        $this->assertNotNull($user->id);
        $this->assertSame('حسین احمدی', $user->name);
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
            'email' => 'test2@example.com',
            'password' => 'plainpassword',
        ]);

        $this->assertNotSame('plainpassword', $user->password);
        $this->assertTrue(password_verify('plainpassword', $user->password));
    }

    public function test_user_can_have_roles(): void
    {
        $user = User::factory()->create();
        $role = \App\Models\Role::create([
            'name' => 'admin',
            'display_name' => 'مدیر',
        ]);

        $user->roles()->attach($role->id);

        $this->assertTrue($user->roles->contains($role->id));
    }

    public function test_user_has_role_method(): void
    {
        $user = User::factory()->create();
        $role = \App\Models\Role::create([
            'name' => 'admin',
            'display_name' => 'مدیر',
        ]);

        $user->roles()->attach($role->id);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertFalse($user->hasRole('nonexistent'));
    }
}
