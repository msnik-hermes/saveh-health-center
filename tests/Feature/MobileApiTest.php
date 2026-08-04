<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PriorityDomainSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MobileApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_token(): void
    {
        $this->seed(PriorityDomainSeeder::class);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@saveh.local',
            'password' => 'password',
            'device_name' => 'phpunit',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['token', 'token_type', 'user' => ['id', 'email']]);
    }

    public function test_protected_endpoints_require_auth(): void
    {
        $this->postJson('/api/v1/facility-requests', [])->assertUnauthorized();
        $this->postJson('/api/v1/it-requests', [])->assertUnauthorized();
        $this->postJson('/api/v1/vehicle-requests', [])->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_mobile_requests(): void
    {
        $this->seed(PriorityDomainSeeder::class);

        $user = User::query()->where('email', 'admin@saveh.local')->firstOrFail();
        Sanctum::actingAs($user);

        $facility = $this->postJson('/api/v1/facility-requests', [
            'location' => 'سالن واکسیناسیون',
            'description' => 'نشتی آب سقف',
            'priority' => 'high',
        ]);
        $facility->assertCreated()->assertJsonPath('success', true);

        $it = $this->postJson('/api/v1/it-requests', [
            'problem_description' => 'پرینتر شبکه قطع است',
            'priority' => 'medium',
        ]);
        $it->assertCreated()->assertJsonPath('success', true);

        $vehicle = $this->postJson('/api/v1/vehicle-requests', [
            'trip_purpose' => 'بازرسی روستا',
            'origin' => 'مرکز بهداشت',
            'destination' => 'روستای آوه',
            'departure_datetime' => now()->addDay()->toDateTimeString(),
            'passenger_count' => 2,
        ]);
        $vehicle->assertCreated()->assertJsonPath('success', true);

        $this->getJson('/api/v1/facility-requests')->assertOk()->assertJsonPath('success', true);
        $this->getJson('/api/v1/it-requests')->assertOk()->assertJsonPath('success', true);
        $this->getJson('/api/v1/vehicle-requests')->assertOk()->assertJsonPath('success', true);
        $this->getJson('/api/v1/auth/me')->assertOk()->assertJsonPath('data.email', 'admin@saveh.local');
    }

    public function test_logout_revokes_current_token(): void
    {
        $this->seed(PriorityDomainSeeder::class);

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@saveh.local',
            'password' => 'password',
            'device_name' => 'logout-test',
        ])->assertOk();

        $token = $login->json('token');
        $this->assertNotEmpty($token);

        $user = User::query()->where('email', 'admin@saveh.local')->firstOrFail();
        $this->assertGreaterThan(0, $user->tokens()->count());

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auth/logout')
            ->assertOk()
            ->assertJsonPath('success', true);

        $user->refresh();
        $this->assertSame(0, $user->tokens()->count());
    }
}
