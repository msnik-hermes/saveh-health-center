<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Inspection;
use App\Models\Center;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InspectionResourceTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsAdmin(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin_insp@test.com',
            'password' => 'password',
        ]);
        $this->actingAs($user);
    }

    public function test_inspection_resource_index(): void
    {
        $this->loginAsAdmin();
        $response = $this->get('/admin/inspections');
        $response->assertStatus(200);
    }

    public function test_inspection_resource_create_page(): void
    {
        $this->loginAsAdmin();
        $response = $this->get('/admin/inspections/create');
        $response->assertStatus(200);
    }

    public function test_inspection_resource_edit_page(): void
    {
        $this->loginAsAdmin();
        $center = Center::create([
            'name' => 'Test Center',
            'code' => uniqid('INS_'),
            'type' => 'hospital',
            'university' => 'Test Uni',
            'province' => 'Tehran',
            'city' => 'Tehran',
            'address' => 'Test Address',
            'status' => 'active',
        ]);
        $employee = Employee::factory()->create([
            'center_id' => $center->id,
        ]);
        $inspection = Inspection::create([
            'center_id' => $center->id,
            'inspector_id' => $employee->id,
            'inspection_type' => 'behdashti',
            'date' => now()->toDateString(),
            'findings' => 'Test findings',
            'compliance_status' => 'motlob',
            'status' => 'takmil_shodeh',
        ]);
        $response = $this->get('/admin/inspections/' . $inspection->id . '/edit');
        $response->assertStatus(200);
    }
}
