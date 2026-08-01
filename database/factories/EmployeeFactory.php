<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'personnel_code' => fake()->unique()->numerify('EMP#####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'national_code' => fake()->unique()->numerify('###########'),
            'birth_date' => fake()->date('Y-m-d', '2000-01-01'),
            'gender' => 'mard',
            'marital_status' => 'motahel',
            'job_title' => fake()->jobTitle(),
            'position' => fake()->jobTitle(),
            'employment_type' => 'rasmi',
            'employment_date' => fake()->date('Y-m-d'),
            'center_id' => 1,
            'department' => fake()->word(),
            'service_type' => 'darmani',
            'status' => 'faal',
            'education_degree' => fake()->randomElement(['kardani', 'karshenaasi', 'doctora']),
            'mobile' => fake()->numerify('09#########'),
        ];
    }
}
