<?php

/**
 * Generate Filament Resources for all Eloquent models.
 * Run: php scripts/generate_filament_resources.php
 */

$root = dirname(__DIR__);
$metaPath = $root . '/storage/app/models_meta.json';
if (! file_exists($metaPath)) {
    fwrite(STDERR, "Missing models_meta.json\n");
    exit(1);
}

$models = json_decode(file_get_contents($metaPath), true);
if (! is_array($models) || $models === []) {
    fwrite(STDERR, "No models in meta\n");
    exit(1);
}

// Models that should not get admin CRUD forms
$skip = [
    'User', // managed carefully / Filament auth
    'RolePermission', // pivot-ish
    'UserRole',
    'EncryptionKey', // security sensitive
    'DigitalCertificate',
    'ActiveSession',
    'ApiLog',
    'AuditLog',
    'BackupLog',
    'UserLoginLog',
    'NetworkMonitoringLog',
    'ActivityLog',
];

// Persian labels + navigation groups
$labels = [
    'AccessChange' => ['تغییر دسترسی', 'تغییرات دسترسی', 'امنیت و دسترسی'],
    'AccessLevel' => ['سطح دسترسی', 'سطوح دسترسی', 'امنیت و دسترسی'],
    'AccessReport' => ['گزارش دسترسی', 'گزارش‌های دسترسی', 'امنیت و دسترسی'],
    'ApprovalRequest' => ['درخواست تأیید', 'درخواست‌های تأیید', 'گردش‌کار'],
    'ApprovalWorkflow' => ['گردش تأیید', 'گردش‌های تأیید', 'گردش‌کار'],
    'AttendanceRecord' => ['حضور و غیاب', 'سوابق حضور', 'منابع انسانی'],
    'Budget' => ['بودجه', 'بودجه‌ها', 'مالی و انبار'],
    'Center' => ['مرکز', 'مراکز', 'سازمان'],
    'CenterBankAccount' => ['حساب بانکی مرکز', 'حساب‌های بانکی', 'سازمان'],
    'CenterClassification' => ['طبقه‌بندی مرکز', 'طبقه‌بندی مراکز', 'سازمان'],
    'CenterEquipment' => ['تجهیزات مرکز', 'تجهیزات مراکز', 'سازمان'],
    'CenterNetworkConnection' => ['اتصال شبکه', 'اتصالات شبکه', 'سازمان'],
    'CenterPhoneLine' => ['خط تلفن مرکز', 'خطوط تلفن', 'سازمان'],
    'CenterRelation' => ['رابطه مراکز', 'روابط مراکز', 'سازمان'],
    'CenterRoom' => ['اتاق مرکز', 'اتاق‌ها', 'سازمان'],
    'CenterType' => ['نوع مرکز', 'انواع مرکز', 'سازمان'],
    'CenterUtility' => ['انشعاب مرکز', 'انشعابات', 'سازمان'],
    'ChronicDiseaseTracking' => ['بیماری مزمن', 'ردیابی بیماری‌های مزمن', 'سلامت و درمان'],
    'Company' => ['شرکت', 'شرکت‌ها', 'سازمان'],
    'CompanyInspection' => ['بازدید شرکت', 'بازدیدهای شرکت', 'بازرسی و ایمنی'],
    'Demographic' => ['جمعیت', 'اطلاعات جمعیتی', 'سلامت خانواده'],
    'DentalService' => ['خدمت دندان', 'خدمات دندانپزشکی', 'سلامت و درمان'],
    'DiseaseSurveillance' => ['نظارت بیماری', 'نظارت بیماری‌ها', 'سلامت و درمان'],
    'Driver' => ['راننده', 'رانندگان', 'پشتیبانی و ناوگان'],
    'EarlyRetirementCase' => ['بازنشستگی پیش از موعد', 'موارد بازنشستگی', 'منابع انسانی'],
    'ElderlyCare' => ['مراقبت سالمند', 'مراقبت سالمندان', 'سلامت خانواده'],
    'Employee' => ['کارمند', 'کارکنان', 'منابع انسانی'],
    'EmployeeContract' => ['قرارداد پرسنل', 'قراردادها', 'منابع انسانی'],
    'EnvironmentalEstablishment' => ['مؤسسه محیطی', 'مؤسسات بهداشت محیط', 'بازرسی و ایمنی'],
    'EnvironmentalInspection' => ['بازرسی محیط', 'بازرسی‌های بهداشت محیط', 'بازرسی و ایمنی'],
    'FacilityRequest' => ['درخواست تاسیسات', 'درخواست‌های تاسیسات', 'پشتیبانی و ناوگان'],
    'FamilyPlanning' => ['تنظیم خانواده', 'تنظیم خانواده', 'سلامت خانواده'],
    'FinancialTransaction' => ['تراکنش مالی', 'تراکنش‌های مالی', 'مالی و انبار'],
    'FormSubmission' => ['ارسال فرم', 'ارسال‌های فرم', 'فرم‌ها'],
    'FormTemplate' => ['قالب فرم', 'قالب‌های فرم', 'فرم‌ها'],
    'FuelRecord' => ['سوخت', 'سوابق سوخت', 'پشتیبانی و ناوگان'],
    'HazardAssessment' => ['ارزیابی خطر', 'ارزیابی‌های خطر', 'بازرسی و ایمنی'],
    'HealthPermit' => ['مجوز بهداشتی', 'مجوزهای بهداشتی', 'بازرسی و ایمنی'],
    'ImmunizationRecord' => ['واکسیناسیون', 'سوابق ایمن‌سازی', 'سلامت و درمان'],
    'InfantChild' => ['نوزاد/کودک', 'نوزادان و کودکان', 'سلامت خانواده'],
    'Inspection' => ['بازرسی', 'بازرسی‌ها', 'بازرسی و ایمنی'],
    'ItRequest' => ['درخواست IT', 'درخواست‌های IT', 'پشتیبانی و ناوگان'],
    'LeaveRecord' => ['مرخصی', 'سوابق مرخصی', 'منابع انسانی'],
    'ManagerAccessLevel' => ['دسترسی مدیر', 'دسترسی مدیران', 'امنیت و دسترسی'],
    'MaternalHealth' => ['سلامت مادر', 'سلامت مادران', 'سلامت خانواده'],
    'MedicalEquipment' => ['تجهیز پزشکی', 'تجهیزات پزشکی', 'مالی و انبار'],
    'MentalHealthClinic' => ['کلینیک سلامت روان', 'کلینیک‌های سلامت روان', 'سلامت و درمان'],
    'OccupationalExamination' => ['معاینات شغلی', 'معاینات شغلی', 'بازرسی و ایمنی'],
    'OfficialCorrespondence' => ['مکاتبه رسمی', 'مکاتبات رسمی', 'سازمان'],
    'OrganizationalUnit' => ['واحد سازمانی', 'واحدهای سازمانی', 'سازمان'],
    'PerformanceEvaluation' => ['ارزیابی عملکرد', 'ارزیابی‌های عملکرد', 'منابع انسانی'],
    'Permission' => ['مجوز', 'مجوزها', 'امنیت و دسترسی'],
    'PestControl' => ['مبارزه با آفات', 'مبارزه با آفات', 'بازرسی و ایمنی'],
    'PregnantWoman' => ['زن باردار', 'زنان باردار', 'سلامت خانواده'],
    'Referral' => ['ارجاع', 'ارجاع‌ها', 'سلامت و درمان'],
    'Role' => ['نقش', 'نقش‌ها', 'امنیت و دسترسی'],
    'SchoolHealth' => ['بهداشت مدارس', 'بهداشت مدارس', 'سلامت خانواده'],
    'SecurityIncident' => ['حادثه امنیتی', 'حوادث امنیتی', 'امنیت و دسترسی'],
    'SecurityPolicy' => ['سیاست امنیتی', 'سیاست‌های امنیتی', 'امنیت و دسترسی'],
    'SimCard' => ['سیم‌کارت', 'سیم‌کارت‌ها', 'پشتیبانی و ناوگان'],
    'StaffTransfer' => ['انتقال پرسنل', 'انتقال‌های پرسنل', 'منابع انسانی'],
    'SuicideStatistic' => ['آمار خودکشی', 'آمار خودکشی', 'سلامت و درمان'],
    'SupplyInventory' => ['موجودی انبار', 'موجودی انبار', 'مالی و انبار'],
    'SystemAlert' => ['هشدار سیستم', 'هشدارهای سیستم', 'امنیت و دسترسی'],
    'ThyroidScreening' => ['غربالگری تیروئید', 'غربالگری تیروئید', 'سلامت و درمان'],
    'TrainingDistribution' => ['توزیع آموزش', 'توزیع‌های آموزشی', 'آموزش'],
    'TrainingMaterial' => ['محتوای آموزشی', 'محتوای آموزشی', 'آموزش'],
    'TrainingServiceRecord' => ['خدمت آموزشی', 'سوابق خدمات آموزشی', 'آموزش'],
    'UnitAccessRestriction' => ['محدودیت واحد', 'محدودیت‌های واحد', 'امنیت و دسترسی'],
    'UserPermission' => ['مجوز کاربر', 'مجوزهای کاربر', 'امنیت و دسترسی'],
    'UtilityPaymentLog' => ['پرداخت انشعاب', 'پرداخت‌های انشعاب', 'مالی و انبار'],
    'VaccineDrug' => ['واکسن/دارو', 'واکسن‌ها و داروها', 'مالی و انبار'],
    'VaccineDrugDistribution' => ['توزیع واکسن/دارو', 'توزیع واکسن و دارو', 'مالی و انبار'],
    'Vehicle' => ['خودرو', 'خودروها', 'پشتیبانی و ناوگان'],
    'VehicleMaintenance' => ['تعمیر خودرو', 'تعمیرات خودرو', 'پشتیبانی و ناوگان'],
    'VehicleRequest' => ['درخواست خودرو', 'درخواست‌های خودرو', 'پشتیبانی و ناوگان'],
    'VehicleTrip' => ['سفر خودرو', 'سفرهای خودرو', 'پشتیبانی و ناوگان'],
    'WorkOrder' => ['دستور کار', 'دستورهای کار', 'پشتیبانی و ناوگان'],
    'YouthHealth' => ['سلامت جوانان', 'سلامت جوانان', 'سلامت خانواده'],
];

$groupSort = [
    'سازمان' => 1,
    'منابع انسانی' => 2,
    'پشتیبانی و ناوگان' => 3,
    'سلامت خانواده' => 4,
    'سلامت و درمان' => 5,
    'بازرسی و ایمنی' => 6,
    'مالی و انبار' => 7,
    'آموزش' => 8,
    'فرم‌ها' => 9,
    'گردش‌کار' => 10,
    'امنیت و دسترسی' => 11,
];

$skipColumns = [
    'id', 'created_at', 'updated_at', 'deleted_at', 'remember_token',
    'password', 'email_verified_at', 'two_factor_secret', 'two_factor_recovery_codes',
];

function studlyToWords(string $name): string
{
    return trim(preg_replace('/([a-z])([A-Z])/', '$1 $2', $name) ?? $name);
}

function pluralizeResource(string $short): string
{
    // Filament page class naming helpers
    if (str_ends_with($short, 'y') && ! str_ends_with($short, 'ey')) {
        return substr($short, 0, -1) . 'ies';
    }
    if (preg_match('/(s|x|z|ch|sh)$/', $short)) {
        return $short . 'es';
    }
    // irregular-ish domain names already plural-ish
    $map = [
        'DiseaseSurveillance' => 'DiseaseSurveillances',
        'ChronicDiseaseTracking' => 'ChronicDiseaseTrackings',
        'ThyroidScreening' => 'ThyroidScreenings',
        'PestControl' => 'PestControls',
        'MaternalHealth' => 'MaternalHealths',
        'SchoolHealth' => 'SchoolHealths',
        'ElderlyCare' => 'ElderlyCares',
        'YouthHealth' => 'YouthHealths',
        'FamilyPlanning' => 'FamilyPlannings',
        'MentalHealthClinic' => 'MentalHealthClinics',
        'SuicideStatistic' => 'SuicideStatistics',
        'SupplyInventory' => 'SupplyInventories',
        'VehicleMaintenance' => 'VehicleMaintenances',
        'InfantChild' => 'InfantChildren',
    ];

    return $map[$short] ?? ($short . 's');
}

function fieldLabel(string $field): string
{
    static $map = [
        'name' => 'نام',
        'title' => 'عنوان',
        'code' => 'کد',
        'status' => 'وضعیت',
        'type' => 'نوع',
        'phone' => 'تلفن',
        'email' => 'ایمیل',
        'address' => 'آدرس',
        'city' => 'شهر',
        'province' => 'استان',
        'district' => 'منطقه',
        'description' => 'توضیحات',
        'notes' => 'یادداشت',
        'center_id' => 'مرکز',
        'company_id' => 'شرکت',
        'employee_id' => 'کارمند',
        'user_id' => 'کاربر',
        'role_id' => 'نقش',
        'permission_id' => 'مجوز',
        'vehicle_id' => 'خودرو',
        'driver_id' => 'راننده',
        'parent_id' => 'والد',
        'is_active' => 'فعال',
        'amount' => 'مبلغ',
        'date' => 'تاریخ',
        'start_date' => 'تاریخ شروع',
        'end_date' => 'تاریخ پایان',
        'request_date' => 'تاریخ درخواست',
        'national_id' => 'کد ملی',
        'registration_number' => 'شماره ثبت',
        'priority' => 'اولویت',
        'level' => 'سطح',
        'gender' => 'جنسیت',
        'birth_date' => 'تاریخ تولد',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'full_name' => 'نام کامل',
        'mobile' => 'موبایل',
        'fax' => 'فکس',
        'website' => 'وب‌سایت',
        'postal_code' => 'کد پستی',
        'capacity' => 'ظرفیت',
        'quantity' => 'تعداد',
        'unit' => 'واحد',
        'price' => 'قیمت',
        'total' => 'جمع',
        'year' => 'سال',
        'month' => 'ماه',
        'reason' => 'دلیل',
        'result' => 'نتیجه',
        'score' => 'امتیاز',
        'location' => 'مکان',
        'plate_number' => 'پلاک',
        'serial_number' => 'شماره سریال',
        'license_number' => 'شماره مجوز',
        'requested_by' => 'درخواست‌کننده',
        'approved_by' => 'تأییدکننده',
        'created_by' => 'ایجادکننده',
        'updated_by' => 'ویرایش‌کننده',
    ];

    if (isset($map[$field])) {
        return $map[$field];
    }

    $label = str_replace('_', ' ', $field);

    return $label;
}

function phpExport(array $arr): string
{
    $parts = [];
    foreach ($arr as $k => $v) {
        $parts[] = var_export((string) $k, true) . ' => ' . var_export((string) $v, true);
    }

    return '[' . implode(', ', $parts) . ']';
}

function detectComponent(string $field, array $casts, array $columnsMeta = []): array
{
    $cast = $casts[$field] ?? null;
    $lower = strtolower($field);

    if (is_string($cast) && str_contains($cast, 'bool')) {
        return ['Toggle', []];
    }
    if (in_array($lower, ['is_active', 'is_granted', 'has_elevator', 'has_generator', 'has_fire_system', 'has_cctv'], true)
        || str_starts_with($lower, 'is_') || str_starts_with($lower, 'has_')) {
        return ['Toggle', []];
    }
    if (is_string($cast) && (str_contains($cast, 'date') || str_contains($cast, 'datetime') || str_contains($cast, 'immutable_date'))) {
        if (str_contains((string) $cast, 'datetime') || str_ends_with($lower, '_at') || str_contains($lower, 'time')) {
            return ['DateTimePicker', []];
        }

        return ['DatePicker', []];
    }
    if (str_ends_with($lower, '_date') || $lower === 'date' || str_ends_with($lower, '_expiry') || $lower === 'birth_date') {
        return ['DatePicker', []];
    }
    if (str_ends_with($lower, '_at') || str_contains($lower, 'datetime')) {
        return ['DateTimePicker', []];
    }
    if (in_array($lower, ['email'], true) || str_ends_with($lower, '_email')) {
        return ['TextInput', ['email' => true]];
    }
    if (in_array($lower, ['phone', 'mobile', 'fax', 'tel'], true) || str_contains($lower, 'phone')) {
        return ['TextInput', ['tel' => true]];
    }
    if (in_array($lower, ['status', 'type', 'priority', 'gender', 'level', 'result'], true) || str_ends_with($lower, '_status') || str_ends_with($lower, '_type')) {
        return ['Select', ['guess' => true]];
    }
    if (str_ends_with($lower, '_id')) {
        return ['TextInput', ['numeric' => true]];
    }
    if (is_string($cast) && (str_contains($cast, 'int') || str_contains($cast, 'float') || str_contains($cast, 'decimal') || str_contains($cast, 'double'))) {
        return ['TextInput', ['numeric' => true]];
    }
    if (in_array($lower, ['amount', 'price', 'total', 'quantity', 'capacity', 'score', 'year', 'month', 'floors', 'rooms_count', 'parking_spaces', 'population_served'], true)
        || str_contains($lower, 'amount') || str_contains($lower, 'count') || str_contains($lower, 'qty')) {
        return ['TextInput', ['numeric' => true]];
    }
    if (in_array($lower, ['address', 'description', 'notes', 'content', 'body', 'details', 'reason', 'comment', 'remarks'], true)
        || str_contains($lower, 'description') || str_contains($lower, 'notes') || str_contains($lower, 'address')) {
        return ['Textarea', ['rows' => 3]];
    }
    if (is_string($cast) && (str_contains($cast, 'array') || str_contains($cast, 'json') || str_contains($cast, 'collection'))) {
        return ['Textarea', ['rows' => 4, 'json' => true]];
    }

    return ['TextInput', []];
}

function statusOptions(string $field): array
{
    $f = strtolower($field);
    if ($f === 'gender') {
        return ['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر'];
    }
    if ($f === 'priority') {
        return ['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'urgent' => 'فوری'];
    }
    if (str_contains($f, 'status') || $f === 'status') {
        return [
            'active' => 'فعال',
            'inactive' => 'غیرفعال',
            'pending' => 'در انتظار',
            'approved' => 'تأیید شده',
            'rejected' => 'رد شده',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'draft' => 'پیش‌نویس',
            'open' => 'باز',
            'closed' => 'بسته',
            'in_progress' => 'در حال انجام',
            'suspended' => 'معلق',
        ];
    }

    return [
        'active' => 'فعال',
        'inactive' => 'غیرفعال',
        'other' => 'سایر',
    ];
}

function buildFormFields(array $fields, array $casts): string
{
    $lines = [];
    $count = 0;
    foreach ($fields as $field) {
        if ($count >= 24) {
            break; // keep forms usable
        }
        [$comp, $opts] = detectComponent($field, $casts);
        $label = fieldLabel($field);
        $lines[] = "                Forms\\Components\\{$comp}::make('{$field}')";
        $lines[] = "                    ->label('{$label}')";
        if ($comp === 'Toggle') {
            $lines[] = '                    ->default(false),';
        } elseif ($comp === 'Select') {
            $options = statusOptions($field);
            $lines[] = '                    ->options(' . phpExport($options) . ')';
            $lines[] = '                    ->searchable()';
            $lines[] = '                    ->native(false),';
        } elseif ($comp === 'Textarea') {
            $rows = $opts['rows'] ?? 3;
            $lines[] = "                    ->rows({$rows})";
            $lines[] = '                    ->columnSpanFull(),';
        } elseif ($comp === 'DatePicker' || $comp === 'DateTimePicker') {
            $lines[] = '                    ->native(false),';
        } else {
            if (! empty($opts['email'])) {
                $lines[] = '                    ->email()';
            }
            if (! empty($opts['tel'])) {
                $lines[] = '                    ->tel()';
            }
            if (! empty($opts['numeric'])) {
                $lines[] = '                    ->numeric()';
            }
            $lines[] = '                    ->maxLength(255),';
        }
        $count++;
    }

    if ($lines === []) {
        $lines[] = "                Forms\\Components\\TextInput::make('id')->label('شناسه')->disabled(),";
    }

    return implode("\n", $lines);
}

function buildTableColumns(array $fields, array $casts): string
{
    $prefer = [];
    foreach (['name', 'title', 'code', 'full_name', 'first_name', 'last_name', 'status', 'type', 'phone', 'city', 'center_id', 'date', 'request_date', 'amount', 'priority', 'is_active'] as $p) {
        if (in_array($p, $fields, true)) {
            $prefer[] = $p;
        }
    }
    foreach ($fields as $f) {
        if (! in_array($f, $prefer, true)) {
            $prefer[] = $f;
        }
        if (count($prefer) >= 8) {
            break;
        }
    }
    if ($prefer === []) {
        $prefer = array_slice($fields, 0, 5);
    }

    $lines = [];
    foreach (array_slice($prefer, 0, 8) as $i => $field) {
        $label = fieldLabel($field);
        $cast = $casts[$field] ?? null;
        $isBool = (is_string($cast) && str_contains($cast, 'bool'))
            || str_starts_with($field, 'is_') || str_starts_with($field, 'has_');
        $isDate = (is_string($cast) && (str_contains($cast, 'date') || str_contains($cast, 'datetime')))
            || str_ends_with($field, '_date') || str_ends_with($field, '_at');

        if ($isBool) {
            $lines[] = "                Tables\\Columns\\IconColumn::make('{$field}')";
            $lines[] = "                    ->label('{$label}')";
            $lines[] = '                    ->boolean(),';
        } else {
            $lines[] = "                Tables\\Columns\\TextColumn::make('{$field}')";
            $lines[] = "                    ->label('{$label}')";
            if ($i < 2) {
                $lines[] = '                    ->searchable()';
                $lines[] = '                    ->sortable()';
            }
            if ($isDate) {
                $lines[] = '                    ->date()';
                $lines[] = '                    ->sortable()';
            }
            if ($field === 'status' || str_ends_with($field, '_status')) {
                $lines[] = '                    ->badge()';
            }
            $lines[] = '                    ->toggleable(),';
        }
    }

    if ($lines === []) {
        $lines[] = "                Tables\\Columns\\TextColumn::make('id')->label('شناسه')->sortable(),";
    }

    return implode("\n", $lines);
}

function writeFile(string $path, string $content): void
{
    $dir = dirname($path);
    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    file_put_contents($path, $content);
}

$generated = [];
$resourcesRoot = $root . '/app/Filament/Resources';

foreach ($models as $model) {
    $short = $model['short'];
    if (in_array($short, $skip, true)) {
        continue;
    }

    $resource = $short . 'Resource';
    $pagesNs = "App\\Filament\\Resources\\{$resource}\\Pages";
    $modelClass = $model['class'];
    $casts = $model['casts'] ?? [];
    $fillable = $model['fillable'] ?? [];
    $columns = $model['columns'] ?? [];

    $fields = $fillable;
    if ($fields === [] && $columns) {
        $fields = array_values(array_filter($columns, fn ($c) => ! in_array($c, $skipColumns, true)));
    } else {
        $fields = array_values(array_filter($fields, fn ($c) => ! in_array($c, $skipColumns, true)));
    }

    [$singular, $plural, $group] = $labels[$short] ?? [
        studlyToWords($short),
        studlyToWords($short),
        'سایر',
    ];

    $navSort = ($groupSort[$group] ?? 50) * 100 + (count($generated) % 50);
    $pluralClass = pluralizeResource($short);
    $listClass = 'List' . $pluralClass;
    $createClass = 'Create' . $short;
    $editClass = 'Edit' . $short;

    $formFields = buildFormFields($fields, $casts);
    $tableCols = buildTableColumns($fields, $casts);

    $resourcePhp = <<<PHP
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\\{$resource}\Pages;
use {$modelClass};
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class {$resource} extends Resource
{
    protected static ?string \$model = {$short}::class;

    protected static ?string \$modelLabel = '{$singular}';

    protected static ?string \$pluralModelLabel = '{$plural}';

    protected static ?string \$navigationLabel = '{$plural}';

    protected static string|\UnitEnum|null \$navigationGroup = '{$group}';

    protected static ?int \$navigationSort = {$navSort};

    public static function form(Schema \$schema): Schema
    {
        return \$schema->schema([
{$formFields}
        ]);
    }

    public static function table(Table \$table): Table
    {
        return \$table
            ->columns([
{$tableCols}
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\\{$listClass}::route('/'),
            'create' => Pages\\{$createClass}::route('/create'),
            'edit' => Pages\\{$editClass}::route('/{record}/edit'),
        ];
    }
}

PHP;

    $listPhp = <<<PHP
<?php

namespace {$pagesNs};

use App\Filament\Resources\\{$resource};
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class {$listClass} extends ListRecords
{
    protected static string \$resource = {$resource}::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

PHP;

    $createPhp = <<<PHP
<?php

namespace {$pagesNs};

use App\Filament\Resources\\{$resource};
use Filament\Resources\Pages\CreateRecord;

class {$createClass} extends CreateRecord
{
    protected static string \$resource = {$resource}::class;
}

PHP;

    $editPhp = <<<PHP
<?php

namespace {$pagesNs};

use App\Filament\Resources\\{$resource};
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class {$editClass} extends EditRecord
{
    protected static string \$resource = {$resource}::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

PHP;

    writeFile("{$resourcesRoot}/{$resource}.php", $resourcePhp);
    writeFile("{$resourcesRoot}/{$resource}/Pages/{$listClass}.php", $listPhp);
    writeFile("{$resourcesRoot}/{$resource}/Pages/{$createClass}.php", $createPhp);
    writeFile("{$resourcesRoot}/{$resource}/Pages/{$editClass}.php", $editPhp);

    $generated[] = [
        'class' => "App\\Filament\\Resources\\{$resource}",
        'short' => $short,
        'group' => $group,
        'plural' => $plural,
    ];
}

// Write AdminPanelProvider with discoverResources (preferred) + explicit fallback list
usort($generated, function ($a, $b) {
    return [$a['group'], $a['plural']] <=> [$b['group'], $b['plural']];
});

$resourceLines = array_map(fn ($g) => '                \\' . $g['class'] . '::class,', $generated);
$resourceBlock = implode("\n", $resourceLines);

$provider = <<<PHP
<?php

namespace App\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel \$panel): Panel
    {
        return \$panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('مرکز بهداشت ساوه')
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::hex('#2d6b4b'),
                'success' => Color::hex('#3f8760'),
                'warning' => Color::hex('#c47b2d'),
                'danger' => Color::Rose,
                'info' => Color::hex('#3d6b78'),
                'gray' => Color::Stone,
            ])
            ->font('Vazirmatn')
            ->viteTheme('resources/css/filament/admin-theme.css')
            ->darkMode(false)
            ->maxContentWidth(Width::Full)
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'سازمان',
                'منابع انسانی',
                'پشتیبانی و ناوگان',
                'سلامت خانواده',
                'سلامت و درمان',
                'بازرسی و ایمنی',
                'مالی و انبار',
                'آموزش',
                'فرم‌ها',
                'گردش‌کار',
                'امنیت و دسترسی',
                'سایر',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\\\Filament\\\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\\\Filament\\\\Pages')
            ->pages([
                \\App\\Filament\\Pages\\Dashboard::class,
            ])
            ->widgets([
                Widgets\\AccountWidget::class,
                \\App\\Filament\\Widgets\\OrganizationStatsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

PHP;

// Fix over-escaped backslashes from heredoc carefulness
$provider = str_replace('App\\\\Filament\\\\Resources', 'App\\Filament\\Resources', $provider);
$provider = str_replace('App\\\\Filament\\\\Pages', 'App\\Filament\\Pages', $provider);
$provider = str_replace('\\App\\Filament\\Pages\\Dashboard::class', \App\Filament\Pages\Dashboard::class . '::class', $provider);
// Actually keep simple - rewrite cleanly:

$provider = <<<'PHP'
<?php

namespace App\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('مرکز بهداشت ساوه')
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::hex('#2d6b4b'),
                'success' => Color::hex('#3f8760'),
                'warning' => Color::hex('#c47b2d'),
                'danger' => Color::Rose,
                'info' => Color::hex('#3d6b78'),
                'gray' => Color::Stone,
            ])
            ->font('Vazirmatn')
            ->viteTheme('resources/css/filament/admin-theme.css')
            ->darkMode(false)
            ->maxContentWidth(Width::Full)
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'سازمان',
                'منابع انسانی',
                'پشتیبانی و ناوگان',
                'سلامت خانواده',
                'سلامت و درمان',
                'بازرسی و ایمنی',
                'مالی و انبار',
                'آموزش',
                'فرم‌ها',
                'گردش‌کار',
                'امنیت و دسترسی',
                'سایر',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                \App\Filament\Widgets\OrganizationStatsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

PHP;

writeFile($root . '/app/Filament/AdminPanelProvider.php', $provider);

$summary = [
    'generated_count' => count($generated),
    'resources' => array_map(fn ($g) => $g['short'] . ' => ' . $g['group'], $generated),
];
file_put_contents($root . '/storage/app/generated_resources.json', json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo 'Generated ' . count($generated) . " resources\n";
foreach ($generated as $g) {
    echo " - {$g['short']} [{$g['group']}]\n";
}
