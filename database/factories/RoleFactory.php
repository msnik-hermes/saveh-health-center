<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['مدیر', 'کارشناس', 'کارمند', 'بازرس', 'سرپرست']),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'hierarchy_level' => fake()->randomElement(['system_admin', 'unit_manager', 'unit_staff']),
            'is_system' => fake()->boolean(20),
        ];
    }
}
