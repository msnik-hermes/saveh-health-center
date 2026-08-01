<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HazardAssessment;

class HazardAssessmentFactory extends Factory
{
    protected $model = HazardAssessment::class;

    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'company_id' => null,
            'assessment_date' => fake()->date('Y-m-d'),
            'assessor_name' => fake()->name(),
            'assessor_qualifications' => fake()->word(),
            'job_title_assessed' => fake()->jobTitle(),
            'workers_in_job' => fake()->numberBetween(1, 50),
            'daily_work_hours' => fake()->randomFloat(1, 4, 12),
            'weekly_work_days' => fake()->numberBetween(5, 7),
            'hazard_categories' => [],
            'physical_hazards' => [],
            'chemical_hazards' => [],
            'biological_hazards' => [],
            'ergonomic_hazards' => [],
            'psychosocial_hazards' => [],
            'risk_category' => fake()->randomElement(['low', 'medium', 'high']),
            'overall_risk' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'control_measures' => [],
            'recommendations' => fake()->sentence(),
            'review_date' => fake()->date('Y-m-d'),
            'assessment_report' => fake()->sentence(),
            'notes' => fake()->optional()->sentence(),
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}
