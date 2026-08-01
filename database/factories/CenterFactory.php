<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Center;

class CenterFactory extends Factory
{
    protected $model = Center::class;

    public function definition(): array
    {
        return [
            'code' => fake()->unique()->numerify('CTR#####'),
            'name' => fake()->company(),
            'type' => fake()->randomElement(['hospital', 'clinic', 'health_center']),
            'parent_id' => null,
            'level' => fake()->numberBetween(1, 5),
            'university' => null,
            'province' => fake()->city(),
            'city' => fake()->city(),
            'district' => fake()->word(),
            'address' => fake()->address(),
            'postal_code' => fake()->numerify('#####'),
            'gps_lat' => fake()->latitude(25, 40),
            'gps_lng' => fake()->longitude(44, 64),
            'phone' => fake()->numerify('09#########'),
            'fax' => fake()->optional()->numerify('021########'),
            'email' => fake()->safeEmail(),
            'website' => fake()->optional()->url(),
            'population_served' => fake()->numberBetween(1000, 500000),
            'service_area_type' => fake()->randomElement(['urban', 'rural', 'mixed']),
            'area_sqm' => fake()->randomFloat(2, 100, 10000),
            'floors' => fake()->numberBetween(1, 10),
            'rooms_count' => fake()->numberBetween(5, 100),
            'parking_spaces' => fake()->numberBetween(0, 50),
            'has_elevator' => fake()->boolean(),
            'has_generator' => fake()->boolean(),
            'generator_power_kw' => fake()->optional()->randomFloat(2, 10, 500),
            'has_fire_system' => fake()->boolean(),
            'has_cctv' => fake()->boolean(),
            'building_type' => fake()->randomElement(['owned', 'rented', 'government']),
            'status' => 'active',
            'established_date' => fake()->date('Y-m-d', '2010-01-01'),
            'license_number' => fake()->numerify('LIC#####'),
            'license_expiry' => fake()->date('Y-m-d', '+2 year'),
            'accreditation_level' => fake()->optional()->randomElement(['A', 'B', 'C']),
            'working_hours_start' => '08:00',
            'working_hours_end' => '17:00',
            'working_days' => 'شنبه تا چهارشنبه',
            'emergency_hours' => '24/7',
            'logo' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
