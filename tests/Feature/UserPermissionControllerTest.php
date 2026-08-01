<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPermissionControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createUser()
    {
        return User::create([
            'name' => 'کاربر تست',
            'email' => uniqid('test') . '@example.com',
            'password' => 'password123',
        ]);
    }

    private function createPermission()
    {
        return Permission::create([
            'name' => 'companies.read',
            'display_name' => 'مشاهده شرکت‌ها',
            'table_name' => 'companies',
            'action' => 'read',
        ]);
    }

    public function test_index(): void
    {
        $response = $this->getJson('/api/user-permissions');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_show(): void
    {
        $user = $this->createUser();
        $permission = $this->createPermission();
        $admin = $this->createUser();

        $userPermission = \App\Models\UserPermission::create([
            'user_id' => $user->id,
            'permission_id' => $permission->id,
            'is_granted' => true,
            'granted_by' => $admin->id,
        ]);

        $response = $this->getJson("/api/user-permissions/{$userPermission->id}");
        $response->assertStatus(200);
        $response->assertJson(['data' => ['is_granted' => true]]);
    }

    public function test_store(): void
    {
        $user = $this->createUser();
        $permission = $this->createPermission();
        $admin = $this->createUser();

        $data = [
            'user_id' => $user->id,
            'permission_id' => $permission->id,
            'is_granted' => true,
            'granted_by' => $admin->id,
        ];

        $response = $this->postJson('/api/user-permissions', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('user_permissions', [
            'user_id' => $user->id,
            'permission_id' => $permission->id,
        ]);
    }

    public function test_store_requires_fields(): void
    {
        $response = $this->postJson('/api/user-permissions', []);
        $response->assertStatus(422);
    }

    public function test_update(): void
    {
        $user = $this->createUser();
        $permission = $this->createPermission();
        $admin = $this->createUser();

        $userPermission = \App\Models\UserPermission::create([
            'user_id' => $user->id,
            'permission_id' => $permission->id,
            'is_granted' => true,
            'granted_by' => $admin->id,
        ]);

        $response = $this->putJson("/api/user-permissions/{$userPermission->id}", [
            'is_granted' => false,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('user_permissions', [
            'id' => $userPermission->id,
            'is_granted' => false,
        ]);
    }

    public function test_destroy(): void
    {
        $user = $this->createUser();
        $permission = $this->createPermission();
        $admin = $this->createUser();

        $userPermission = \App\Models\UserPermission::create([
            'user_id' => $user->id,
            'permission_id' => $permission->id,
            'is_granted' => true,
            'granted_by' => $admin->id,
        ]);

        $response = $this->deleteJson("/api/user-permissions/{$userPermission->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('user_permissions', ['id' => $userPermission->id]);
    }
}
