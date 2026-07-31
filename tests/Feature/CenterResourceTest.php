<?php

namespace Tests\Feature;

use Tests\TestCase;

class CenterResourceTest extends TestCase
{
    public function test_center_resource_index() {
        $response = $this->get('/admin/centers');
        $response->assertStatus(200);
    }

    public function test_center_resource_create() {
        $response = $this->get('/admin/centers/create');
        $response->assertStatus(200);
    }

    public function test_center_resource_store() {
        $data = [
            'name' => 'مرکز سلامت تست',
            'code' => 'TEST001',
            'type' => 'hospital',
            'address' => 'آدرس تست',
            'phone' => '09123456789',
            'email' => 'test@center.com',
            'manager_id' => '1',
            'status' => 'active'
        ];
        $response = $this->post('/admin/centers', $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('centers', $data);
    }

    public function test_center_resource_edit() {
        $center = $this->createCenter();
        $response = $this->get("/admin/centers/{$center->id}/edit");
        $response->assertStatus(200);
    }

    public function test_center_resource_update() {
        $center = $this->createCenter();
        $response = $this->put("/admin/centers/{$center->id}", [
            'name' => 'مرکز سلامت به روز رسانی شده',
            'status' => 'inactive'
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('centers', [
            'id' => $center->id,
            'name' => 'مرکز سلامت به روز رسانی شده',
            'status' => 'inactive'
        ]);
    }

    public function test_center_resource_destroy() {
        $center = $this->createCenter();
        $centerId = $center->id;
        $response = $this->delete("/admin/centers/{$centerId}");
        $response->assertRedirect();
        $this->assertSoftDeleted('centers', ['id' => $centerId]);
    }

    protected function createCenter() {
        return $this->center = \App\Models\Center::create([
            'name' => 'مرکز سلامت تست',
            'code' => 'TEST001',
            'type' => 'hospital',
            'address' => 'آدرس تست',
            'phone' => '09123456789',
            'email' => 'test@center.com',
            'manager_id' => '1',
            'status' => 'active'
        ]);
    }
}
