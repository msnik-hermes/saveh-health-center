<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\HazardAssessment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HazardAssessmentResourceTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsAdmin(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin_ha@test.com',
            'password' => 'password',
        ]);
        $this->actingAs($user);
    }

    public function test_hazard_assessment_resource_index(): void
    {
        $this->loginAsAdmin();
        $response = $this->get('/admin/hazard-assessments');
        $response->assertStatus(200);
    }

    public function test_hazard_assessment_resource_create_page(): void
    {
        $this->loginAsAdmin();
        $response = $this->get('/admin/hazard-assessments/create');
        $response->assertStatus(200);
    }

    public function test_hazard_assessment_resource_edit_page(): void
    {
        $this->loginAsAdmin();
        $ha = HazardAssessment::create([
            'company_name' => 'Test Company',
            'assessment_date' => now()->toDateString(),
            'assessor_name' => 'Test Assessor',
            'job_title_assessed' => 'Test Job',
            'hazard_categories' => 'physical, chemical',
        ]);
        $response = $this->get('/admin/hazard-assessments/' . $ha->id . '/edit');
        $response->assertStatus(200);
    }
}
