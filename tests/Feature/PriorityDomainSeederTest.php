<?php

namespace Tests\Feature;

use Database\Seeders\PriorityDomainSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriorityDomainSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_priority_domain_seeder_creates_core_records(): void
    {
        $this->seed(PriorityDomainSeeder::class);

        $this->assertDatabaseHas('users', ['email' => 'admin@saveh.local']);
        $this->assertDatabaseHas('roles', ['name' => 'admin']);
        $this->assertDatabaseHas('centers', ['code' => 'SVH-001']);
        $this->assertDatabaseHas('center_types', ['code' => 'MC']);
        $this->assertDatabaseHas('companies', ['name' => 'شرکت نمونه صنعتی ساوه']);
        $this->assertDatabaseHas('employees', ['personnel_code' => 'PR-1001']);
        $this->assertDatabaseHas('vehicles', ['plate_number' => '12ب34567']);
        $this->assertDatabaseHas('facility_requests', ['request_number' => 'FAC-1001']);
        $this->assertDatabaseHas('it_requests', ['problem_description' => 'قطع پرینتر شبکه']);
        $this->assertDatabaseHas('training_materials', ['title' => 'پوستر تغذیه سالم']);
        $this->assertDatabaseHas('work_orders', ['order_number' => 'WO-1001']);
        $this->assertDatabaseHas('sim_cards', ['phone_number' => '09120001122']);
    }
}
