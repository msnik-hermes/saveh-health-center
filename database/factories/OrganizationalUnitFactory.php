<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrganizationalUnit;

class OrganizationalUnitFactory extends Factory
{
    protected $model = OrganizationalUnit::class;

    public function definition(): array
    {
        return [
            'center_id' => null,
            'parent_id' => null,
            'code' => fake()->unique()->numerify('U#####'),
            'name' => fake()->word(),
            'name_en' => fake()->word(),
            'head_employee_id' => null,
            'phone' => fake()->numerify('09#########'),
            'budget_allocation' => fake()->numberBetween(1000000, 50000000),
            'description' => fake()->sentence(),
            'status' => 'active',
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }
}
