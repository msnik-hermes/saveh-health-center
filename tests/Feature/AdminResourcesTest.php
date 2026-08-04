<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_available(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_guest_is_redirected_from_admin_resources(): void
    {
        $this->get('/admin/centers')->assertRedirect();
        $this->get('/admin/employees')->assertRedirect();
        $this->get('/admin/vehicles')->assertRedirect();
        $this->get('/admin/training-materials')->assertRedirect();
    }

    public function test_authenticated_admin_can_open_priority_resource_pages(): void
    {
        $user = User::factory()->create([
            'email' => 'tester@saveh.local',
            'password' => 'password',
            'is_active' => true,
        ]);

        $paths = [
            '/admin',
            '/admin/centers',
            '/admin/center-types',
            '/admin/companies',
            '/admin/organizational-units',
            '/admin/center-rooms',
            '/admin/center-equipment',
            '/admin/center-phone-lines',
            '/admin/center-utilities',
            '/admin/employees',
            '/admin/employee-contracts',
            '/admin/attendance-records',
            '/admin/leave-records',
            '/admin/performance-evaluations',
            '/admin/staff-transfers',
            '/admin/early-retirement-cases',
            '/admin/facility-requests',
            '/admin/it-requests',
            '/admin/vehicle-requests',
            '/admin/vehicles',
            '/admin/drivers',
            '/admin/vehicle-trips',
            '/admin/fuel-records',
            '/admin/work-orders',
            '/admin/sim-cards',
            '/admin/training-materials',
            '/admin/training-distributions',
            '/admin/training-service-records',
        ];

        foreach ($paths as $path) {
            $this->actingAs($user)
                ->get($path)
                ->assertSuccessful();
        }
    }

    public function test_all_filament_resources_are_registered(): void
    {
        $files = glob(app_path('Filament/Resources/*Resource.php')) ?: [];
        $this->assertGreaterThanOrEqual(70, count($files));

        foreach ($files as $file) {
            $class = 'App\\Filament\\Resources\\' . basename($file, '.php');
            $this->assertTrue(class_exists($class), "Missing class {$class}");
            $pages = $class::getPages();
            $this->assertArrayHasKey('index', $pages);
            $this->assertArrayHasKey('create', $pages);
            $this->assertArrayHasKey('edit', $pages);
            $this->assertNotEmpty($class::getNavigationLabel());
            $this->assertTrue($class::shouldRegisterNavigation());
        }
    }
}
