<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CompanyInspection;
use App\Models\Employee;

class CompanyInspectionFactory extends Factory
{
    protected $model = CompanyInspection::class;

    public function definition(): array
    {
        return [
            'company_id' => null,
            'company_name' => fake()->company(),
            'inspector_id' => Employee::factory(),
            'inspection_type' => fake()->randomElement(['routine', 'follow_up', 'complaint']),
            'inspection_date' => fake()->date('Y-m-d'),
            'workers_inspected' => fake()->numberBetween(1, 100),
            'findings' => fake()->paragraph(),
            'violations_found' => fake()->numberBetween(0, 10),
            'compliance_score' => fake()->randomFloat(2, 0, 100),
            'violations' => [],
            'corrective_actions' => fake()->optional()->sentence(),
            'next_inspection_date' => fake()->optional()->date('Y-m-d', '+1 year'),
            'status' => fake()->randomElement(['draft', 'completed', 'pending']),
            'photos' => [],
            'notes' => fake()->optional()->sentence(),
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}
