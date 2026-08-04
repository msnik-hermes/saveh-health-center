<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\Center;
use App\Models\CenterEquipment;
use App\Models\CenterPhoneLine;
use App\Models\CenterRoom;
use App\Models\CenterType;
use App\Models\CenterUtility;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\EmployeeContract;
use App\Models\FacilityRequest;
use App\Models\FuelRecord;
use App\Models\ItRequest;
use App\Models\LeaveRecord;
use App\Models\OrganizationalUnit;
use App\Models\PerformanceEvaluation;
use App\Models\Role;
use App\Models\SimCard;
use App\Models\StaffTransfer;
use App\Models\TrainingDistribution;
use App\Models\TrainingMaterial;
use App\Models\TrainingServiceRecord;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleRequest;
use App\Models\VehicleTrip;
use App\Models\WorkOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class PriorityDomainSeeder extends Seeder
{
    public function run(): void
    {
        // admin user is created after center/employee so we can attach IDs

        // Center types
        $types = [
            ['name' => 'مرکز بهداشت شهرستان', 'code' => 'MC', 'description' => 'سطح شهرستان', 'capacity' => 500, 'is_active' => true],
            ['name' => 'مرکز جامع سلامت', 'code' => 'CHC', 'description' => 'مرکز جامع', 'capacity' => 300, 'is_active' => true],
            ['name' => 'پایگاه سلامت', 'code' => 'HP', 'description' => 'پایگاه', 'capacity' => 100, 'is_active' => true],
            ['name' => 'خانه بهداشت', 'code' => 'HH', 'description' => 'روستایی', 'capacity' => 50, 'is_active' => true],
        ];
        foreach ($types as $type) {
            CenterType::query()->updateOrCreate(['code' => $type['code']], $type);
        }

        $center = Center::query()->first();
        if (! $center) {
            $centerData = $this->onlyFillable(Center::class, [
                'code' => 'SVH-001',
                'name' => 'مرکز بهداشت شهرستان ساوه',
                'type' => 'khane_behdasht',
                'university' => 'دانشگاه علوم پزشکی اراک',
                'province' => 'مرکزی',
                'city' => 'ساوه',
                'address' => 'ساوه، بلوار انقلاب، مرکز بهداشت شهرستان',
                'status' => 'faal',
                'phone' => '086-42220000',
            ]);
            $center = Center::query()->create($centerData);
        }

        Company::query()->updateOrCreate(
            ['name' => 'شرکت نمونه صنعتی ساوه'],
            $this->onlyFillable(Company::class, [
                'name' => 'شرکت نمونه صنعتی ساوه',
                'registration_number' => '123456',
                'national_id' => '14000000000',
                'status' => 'faal',
                'city' => 'ساوه',
                'province' => 'مرکزی',
                'phone' => '086-42221111',
            ])
        );

        $unit = OrganizationalUnit::query()->updateOrCreate(
            ['code' => 'UNIT-HEALTH'],
            $this->onlyFillable(OrganizationalUnit::class, [
                'center_id' => $center->id,
                'code' => 'UNIT-HEALTH',
                'name' => 'واحد بهداشت محیط',
                'status' => 'faal',
            ])
        );

        CenterRoom::query()->updateOrCreate(
            ['center_id' => $center->id, 'room_number' => 'A-101'],
            $this->onlyFillable(CenterRoom::class, [
                'center_id' => $center->id,
                'room_number' => 'A-101',
                'name' => 'اتاق واکسیناسیون',
                'floor' => 1,
                'status' => 'faal',
            ])
        );

        CenterEquipment::query()->updateOrCreate(
            ['center_id' => $center->id, 'name' => 'یخچال واکسن'],
            $this->onlyFillable(CenterEquipment::class, [
                'center_id' => $center->id,
                'name' => 'یخچال واکسن',
                'status' => 'faal',
            ])
        );

        CenterPhoneLine::query()->updateOrCreate(
            ['center_id' => $center->id, 'phone_number' => '08642220001'],
            $this->onlyFillable(CenterPhoneLine::class, [
                'center_id' => $center->id,
                'phone_number' => '08642220001',
                'status' => 'faal',
            ])
        );

        CenterUtility::query()->updateOrCreate(
            ['center_id' => $center->id, 'company' => 'شرکت برق'],
            $this->onlyFillable(CenterUtility::class, [
                'center_id' => $center->id,
                'company' => 'شرکت برق',
                'status' => 'faal',
            ])
        );

        // Employee via DB for strict NOT NULL columns
        $employeeId = DB::table('employees')->where('personnel_code', 'PR-1001')->value('id');
        if (! $employeeId) {
            $employeeId = DB::table('employees')->insertGetId([
                'center_id' => $center->id,
                'personnel_code' => 'PR-1001',
                'first_name' => 'علی',
                'last_name' => 'محمدی',
                'national_code' => '0012345678',
                'birth_date' => '1990-01-01',
                'job_title' => 'کارشناس بهداشت',
                'position' => 'کارشناس',
                'employment_date' => '2020-01-01',
                'department' => 'بهداشت محیط',
                'education_degree' => 'karshenasi',
                'mobile' => '09121234567',
                'status' => 'faal',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $employee = Employee::query()->find($employeeId);

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@saveh.local'],
            [
                'name' => 'مدیر سیستم',
                'password' => Hash::make('password'),
                'is_active' => true,
                'center_id' => $center->id,
                'employee_id' => $employee?->id,
            ]
        );

        $role = Role::query()->updateOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'مدیر سیستم', 'description' => 'دسترسی کامل']
        );
        if (method_exists($admin, 'roles')) {
            $admin->roles()->syncWithoutDetaching([$role->id]);
        }

        EmployeeContract::query()->updateOrCreate(
            ['employee_id' => $employee->id, 'start_date' => '2020-01-01'],
            $this->onlyFillable(EmployeeContract::class, [
                'employee_id' => $employee->id,
                'start_date' => '2020-01-01',
                'status' => 'faal',
            ])
        );

        AttendanceRecord::query()->updateOrCreate(
            ['employee_id' => $employee->id, 'date' => now()->toDateString()],
            $this->onlyFillable(AttendanceRecord::class, [
                'employee_id' => $employee->id,
                'date' => now()->toDateString(),
                'status' => 'hazer',
            ])
        );

        LeaveRecord::query()->updateOrCreate(
            ['employee_id' => $employee->id, 'start_date' => now()->subDays(10)->toDateString()],
            $this->onlyFillable(LeaveRecord::class, [
                'employee_id' => $employee->id,
                'start_date' => now()->subDays(10)->toDateString(),
                'end_date' => now()->subDays(8)->toDateString(),
                'days_count' => 3,
                'status' => 'dar_barresi',
            ])
        );

        PerformanceEvaluation::query()->updateOrCreate(
            ['employee_id' => $employee->id, 'evaluation_period' => '1404-H1'],
            $this->onlyFillable(PerformanceEvaluation::class, [
                'employee_id' => $employee->id,
                'evaluation_period' => '1404-H1',
                'evaluator_id' => $employee->id,
                'overall_score' => 85,
                'status' => 'pishnevis',
            ])
        );

        StaffTransfer::query()->updateOrCreate(
            ['employee_id' => $employee->id, 'transfer_date' => now()->toDateString()],
            $this->onlyFillable(StaffTransfer::class, [
                'employee_id' => $employee->id,
                'transfer_date' => now()->toDateString(),
                'status' => 'dar_entzaar',
            ])
        );

        // Fleet / support
        $vehicle = Vehicle::query()->updateOrCreate(
            ['plate_number' => '12ب34567'],
            $this->onlyFillable(Vehicle::class, [
                'plate_number' => '12ب34567',
                'make' => 'پژو',
                'model' => '405',
                'year' => 2018,
                'center_id' => $center->id,
                'status' => 'faal',
            ])
        );

        $driver = Driver::query()->updateOrCreate(
            ['employee_id' => $employee->id],
            $this->onlyFillable(Driver::class, [
                'employee_id' => $employee->id,
                'license_number' => 'DRV-7788',
                'license_type' => 'base2',
                'license_expiry' => now()->addYears(2)->toDateString(),
                'status' => 'faal',
            ])
        );

        FacilityRequest::query()->updateOrCreate(
            ['request_number' => 'FAC-1001'],
            $this->onlyFillable(FacilityRequest::class, [
                'request_number' => 'FAC-1001',
                'center_id' => $center->id,
                'requested_by' => $employee->id,
                'location' => 'سالن واکسیناسیون',
                'description' => 'نشتی آب از سقف',
                'status' => 'ersal_shodeh',
            ])
        );

        ItRequest::query()->updateOrCreate(
            [
                'center_id' => $center->id,
                'requested_by' => $employee->id,
                'problem_description' => 'قطع پرینتر شبکه',
            ],
            $this->onlyFillable(ItRequest::class, [
                'center_id' => $center->id,
                'requested_by' => $employee->id,
                'problem_description' => 'قطع پرینتر شبکه',
                'status' => 'ersal_shodeh',
            ])
        );

        VehicleRequest::query()->updateOrCreate(
            ['request_number' => 'VEH-1001'],
            $this->onlyFillable(VehicleRequest::class, [
                'request_number' => 'VEH-1001',
                'center_id' => $center->id,
                'requested_by' => $employee->id,
                'trip_purpose' => 'بازرسی روستا',
                'origin' => 'مرکز بهداشت ساوه',
                'destination' => 'روستای آوه',
                'departure_datetime' => now()->addDay(),
                'status' => 'ersal_shodeh',
            ])
        );

        VehicleTrip::query()->updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'trip_date' => now()->toDateString(), 'origin' => 'ساوه'],
            $this->onlyFillable(VehicleTrip::class, [
                'vehicle_id' => $vehicle->id,
                'driver_id' => $driver->id,
                'trip_date' => now()->toDateString(),
                'departure_time' => '08:00:00',
                'origin' => 'ساوه',
                'destination' => 'آوه',
                'start_mileage' => 120000,
                'trip_purpose' => 'بازرسی',
            ])
        );

        FuelRecord::query()->updateOrCreate(
            ['vehicle_id' => $vehicle->id, 'date' => now()->toDateString()],
            $this->onlyFillable(FuelRecord::class, [
                'vehicle_id' => $vehicle->id,
                'date' => now()->toDateString(),
                'quantity' => 30,
                'cost' => 1500000,
            ])
        );

        WorkOrder::query()->updateOrCreate(
            ['order_number' => 'WO-1001'],
            $this->onlyFillable(WorkOrder::class, [
                'center_id' => $center->id,
                'order_number' => 'WO-1001',
                'description' => 'تعویض لامپ راهرو',
                'status' => 'mallaq',
            ])
        );

        SimCard::query()->updateOrCreate(
            ['phone_number' => '09120001122'],
            $this->onlyFillable(SimCard::class, [
                'phone_number' => '09120001122',
                'operator' => 'همراه اول',
                'card_type' => 'دائمی',
                'center_id' => $center->id,
                'status' => 'faal',
            ])
        );

        // Training
        $material = TrainingMaterial::query()->updateOrCreate(
            ['title' => 'پوستر تغذیه سالم'],
            $this->onlyFillable(TrainingMaterial::class, [
                'title' => 'پوستر تغذیه سالم',
                'type' => 'poster',
                'category' => 'تغذیه',
                'production_date' => now()->subMonths(2)->toDateString(),
            ])
        );

        TrainingDistribution::query()->updateOrCreate(
            [
                'material_id' => $material->id,
                'center_id' => $center->id,
                'distribution_date' => now()->toDateString(),
            ],
            $this->onlyFillable(TrainingDistribution::class, [
                'material_id' => $material->id,
                'center_id' => $center->id,
                'distribution_date' => now()->toDateString(),
                'quantity' => 50,
            ])
        );

        TrainingServiceRecord::query()->updateOrCreate(
            [
                'center_id' => $center->id,
                'session_date' => now()->toDateString(),
                'topic' => 'آموزش بهداشت دست',
            ],
            $this->onlyFillable(TrainingServiceRecord::class, [
                'center_id' => $center->id,
                'session_date' => now()->toDateString(),
                'topic' => 'آموزش بهداشت دست',
                'participants_count' => 25,
            ])
        );
    }

    private function onlyFillable(string $modelClass, array $data): array
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $modelClass;
        $fillable = $model->getFillable();
        if ($fillable === []) {
            return $data;
        }

        return array_intersect_key($data, array_flip($fillable));
    }
}
