<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminDemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@saveh.local'],
            [
                'name' => 'مدیر سیستم',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $role = Role::query()->updateOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'مدیر سیستم',
                'description' => 'دسترسی کامل پنل',
            ]
        );

        if (method_exists($admin, 'roles')) {
            $admin->roles()->syncWithoutDetaching([$role->id]);
        }

        $center = Center::query()->first();
        if (! $center) {
            $fillable = (new Center)->getFillable();
            $data = array_intersect_key([
                'name' => 'مرکز بهداشت شهرستان ساوه',
                'code' => 'SVH-001',
                'type' => 'county',
                'university' => 'دانشگاه علوم پزشکی اراک',
                'province' => 'مرکزی',
                'city' => 'ساوه',
                'status' => 'active',
                'phone' => '086-42220000',
                'address' => 'ساوه، مرکز بهداشت شهرستان',
            ], array_flip($fillable));
            $center = Center::query()->create($data);
        }

        if (Company::query()->count() === 0) {
            $fillable = (new Company)->getFillable();
            $data = array_intersect_key([
                'name' => 'شرکت نمونه صنعتی ساوه',
                'registration_number' => '123456',
                'national_id' => '14000000000',
                'status' => 'active',
                'city' => 'ساوه',
                'province' => 'مرکزی',
                'phone' => '086-42221111',
            ], array_flip($fillable));
            if ($data) {
                Company::query()->create($data);
            }
        }

        if (Employee::query()->count() === 0 && $center) {
            try {
                // Use query builder to bypass guarded/fillable surprises for required NOT NULL columns
                DB::table('employees')->insert([
                    'center_id' => $center->id,
                    'first_name' => 'علی',
                    'last_name' => 'محمدی',
                    'personnel_code' => 'PR-1001',
                    'national_code' => '0000000000',
                    'gender' => 'male',
                    'status' => 'active',
                    'job_title' => 'کارشناس بهداشت',
                    'birth_date' => '1990-01-01',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Throwable $e) {
                // ignore demo employee failures; forms still available
            }
        }
    }
}
