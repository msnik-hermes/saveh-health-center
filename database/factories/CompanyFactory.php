<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'status' => 'faal',
            'phone' => fake()->numerify('09#########'),
            'email' => fake()->safeEmail(),
        ];
    }
}
