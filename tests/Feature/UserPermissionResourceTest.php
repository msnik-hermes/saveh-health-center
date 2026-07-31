<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserPermissionResourceTest extends TestCase
{
    public function test_user_permission_resource_index() {
        $response = $this->get('/admin/user-permissions');
        $response->assertStatus(200);
    }

    public function test_user_permission_resource_create() {
        $response = $this->get('/admin/user-permissions/create');
        $response->assertStatus(200);
    }

    public function test_user_permission_resource_store() {
        $data = ['user_id' => '1', 'permission_id' => '1', 'is_granted' => true];
        $response = $this->post('/admin/user-permissions', $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('user_permissions', $data);
    }

    public function test_user_permission_resource_edit() {
        $permission = $this->createUserPermission();
        $response = $this->get("/admin/user-permissions/{$permission->id}/edit");
        $response->assertStatus(200);
    }

    public function test_user_permission_resource_update() {
        $permission = $this->createUserPermission();
        $response = $this->put("/admin/user-permissions/{$permission->id}", ['is_granted' => false]);
        $response->assertRedirect();
        $this->assertDatabaseHas('user_permissions', ['id' => $permission->id, 'is_granted' => false]);
    }

    public function test_user_permission_resource_destroy() {
        $permission = $this->createUserPermission();
        $permissionId = $permission->id;
        $response = $this->delete("/admin/user-permissions/{$permissionId}");
        $response->assertRedirect();
        $this->assertSoftDeleted('user_permissions', ['id' => $permissionId]);
    }

    protected function createUserPermission() {
        return $this->permission = \App\Models\UserPermission::create([
            'user_id' => '1',
            'permission_id' => '1',
            'is_granted' => true
        ]);
    }
}
