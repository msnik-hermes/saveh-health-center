<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CenterControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createCenter(array $overrides = [])
    {
        return \App\Models\Center::create(array_merge([
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
        ], $overrides));
    }

    public function test_centers_index(): void
    {
        $response = $this->getJson('/api/centers');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_centers_show(): void
    {
        $center = $this->createCenter();
        $response = $this->getJson("/api/centers/{$center->id}");
        $response->assertStatus(200);
        $response->assertJson(['data' => ['name' => 'مرکز سلامت تست']]);
    }

    public function test_centers_store(): void
    {
        $data = [
            'name' => 'مرکز جدید',
            'code' => 'NEW001',
            'type' => 'clinic',
            'university' => 'دانشگاه علوم پزشکی',
            'province' => 'تهران',
            'city' => 'تهران',
            'address' => 'آدرس جدید',
            'status' => 'active',
        ];

        $response = $this->postJson('/api/centers', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('centers', ['name' => 'مرکز جدید', 'code' => 'NEW001']);
    }

    public function test_centers_store_requires_name(): void
    {
        $response = $this->postJson('/api/centers', []);
        $response->assertStatus(422);
    }

    public function test_centers_update(): void
    {
        $center = $this->createCenter();

        $response = $this->putJson("/api/centers/{$center->id}", [
            'name' => 'مرکز بروزرسانی شده',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('centers', [
            'id' => $center->id,
            'name' => 'مرکز بروزرسانی شده',
        ]);
    }

    public function test_centers_destroy(): void
    {
        $center = $this->createCenter();
        $centerId = $center->id;

        $response = $this->deleteJson("/api/centers/{$centerId}");
        $response->assertStatus(200);
        $this->assertSoftDeleted('centers', ['id' => $centerId]);
    }
}
