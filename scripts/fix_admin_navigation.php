<?php

/**
 * Normalize Filament resource navigation: Heroicon enums, Persian groups, sort order.
 * php scripts/fix_admin_navigation.php
 */

$root = dirname(__DIR__);
$resourcesDir = $root . '/app/Filament/Resources';

$map = [
    // سازمان
    'CenterResource' => ['سازمان', 'BuildingOffice2', 10, 'مراکز'],
    'CenterTypeResource' => ['سازمان', 'Tag', 20, 'انواع مرکز'],
    'CompanyResource' => ['سازمان', 'Briefcase', 30, 'شرکت‌ها'],
    'OrganizationalUnitResource' => ['سازمان', 'BuildingLibrary', 40, 'واحدهای سازمانی'],
    'CenterRoomResource' => ['سازمان', 'HomeModern', 50, 'اتاق‌ها'],
    'CenterEquipmentResource' => ['سازمان', 'CpuChip', 60, 'تجهیزات مراکز'],
    'CenterPhoneLineResource' => ['سازمان', 'Phone', 70, 'خطوط تلفن'],
    'CenterUtilityResource' => ['سازمان', 'Bolt', 80, 'انشعابات'],
    'CenterBankAccountResource' => ['سازمان', 'CreditCard', 90, 'حساب‌های بانکی'],
    'CenterNetworkConnectionResource' => ['سازمان', 'Signal', 100, 'اتصالات شبکه'],
    'CenterRelationResource' => ['سازمان', 'Share', 110, 'روابط مراکز'],
    'CenterClassificationResource' => ['سازمان', 'Squares2X2', 120, 'طبقه‌بندی مراکز'],
    'OfficialCorrespondenceResource' => ['سازمان', 'Envelope', 130, 'مکاتبات رسمی'],

    // منابع انسانی
    'EmployeeResource' => ['منابع انسانی', 'Users', 10, 'کارکنان'],
    'EmployeeContractResource' => ['منابع انسانی', 'DocumentText', 20, 'قراردادها'],
    'AttendanceRecordResource' => ['منابع انسانی', 'Clock', 30, 'حضور و غیاب'],
    'LeaveRecordResource' => ['منابع انسانی', 'CalendarDays', 40, 'مرخصی‌ها'],
    'PerformanceEvaluationResource' => ['منابع انسانی', 'ChartBarSquare', 50, 'ارزیابی عملکرد'],
    'StaffTransferResource' => ['منابع انسانی', 'ArrowsUpDown', 60, 'انتقال پرسنل'],
    'EarlyRetirementCaseResource' => ['منابع انسانی', 'Flag', 70, 'بازنشستگی پیش از موعد'],

    // پشتیبانی و ناوگان
    'FacilityRequestResource' => ['پشتیبانی و ناوگان', 'WrenchScrewdriver', 10, 'درخواست‌های تاسیسات'],
    'ItRequestResource' => ['پشتیبانی و ناوگان', 'ComputerDesktop', 20, 'درخواست‌های IT'],
    'VehicleRequestResource' => ['پشتیبانی و ناوگان', 'Map', 30, 'درخواست‌های خودرو'],
    'VehicleResource' => ['پشتیبانی و ناوگان', 'Truck', 40, 'خودروها'],
    'DriverResource' => ['پشتیبانی و ناوگان', 'Identification', 50, 'رانندگان'],
    'VehicleTripResource' => ['پشتیبانی و ناوگان', 'MapPin', 60, 'سفرهای خودرو'],
    'FuelRecordResource' => ['پشتیبانی و ناوگان', 'Fire', 70, 'سوابق سوخت'],
    'WorkOrderResource' => ['پشتیبانی و ناوگان', 'ClipboardDocumentList', 80, 'دستورهای کار'],
    'SimCardResource' => ['پشتیبانی و ناوگان', 'DevicePhoneMobile', 90, 'سیم‌کارت‌ها'],
    'VehicleMaintenanceResource' => ['پشتیبانی و ناوگان', 'Cog6Tooth', 100, 'تعمیرات خودرو'],

    // آموزش
    'TrainingMaterialResource' => ['آموزش', 'BookOpen', 10, 'محتوای آموزشی'],
    'TrainingDistributionResource' => ['آموزش', 'PaperAirplane', 20, 'توزیع آموزشی'],
    'TrainingServiceRecordResource' => ['آموزش', 'ClipboardDocument', 30, 'سوابق آموزش'],

    // سلامت خانواده
    'PregnantWomanResource' => ['سلامت خانواده', 'Heart', 10, 'زنان باردار'],
    'MaternalHealthResource' => ['سلامت خانواده', 'Heart', 20, 'سلامت مادران'],
    'InfantChildResource' => ['سلامت خانواده', 'User', 30, 'نوزادان و کودکان'],
    'SchoolHealthResource' => ['سلامت خانواده', 'AcademicCap', 40, 'بهداشت مدارس'],
    'ElderlyCareResource' => ['سلامت خانواده', 'Heart', 50, 'مراقبت سالمندان'],
    'YouthHealthResource' => ['سلامت خانواده', 'Sparkles', 60, 'سلامت جوانان'],
    'DemographicResource' => ['سلامت خانواده', 'ChartBar', 70, 'اطلاعات جمعیتی'],
    'FamilyPlanningResource' => ['سلامت خانواده', 'Home', 80, 'تنظیم خانواده'],

    // سلامت و درمان
    'DiseaseSurveillanceResource' => ['سلامت و درمان', 'Beaker', 10, 'نظارت بیماری‌ها'],
    'ImmunizationRecordResource' => ['سلامت و درمان', 'ShieldCheck', 20, 'ایمن‌سازی'],
    'ChronicDiseaseTrackingResource' => ['سلامت و درمان', 'Heart', 30, 'بیماری‌های مزمن'],
    'ThyroidScreeningResource' => ['سلامت و درمان', 'Beaker', 40, 'غربالگری تیروئید'],
    'DentalServiceResource' => ['سلامت و درمان', 'FaceSmile', 50, 'خدمات دندانپزشکی'],
    'MentalHealthClinicResource' => ['سلامت و درمان', 'ChatBubbleLeftRight', 60, 'سلامت روان'],
    'ReferralResource' => ['سلامت و درمان', 'ArrowTopRightOnSquare', 70, 'ارجاع‌ها'],
    'SuicideStatisticResource' => ['سلامت و درمان', 'PresentationChartLine', 80, 'آمار خودکشی'],

    // بازرسی
    'InspectionResource' => ['بازرسی و ایمنی', 'ClipboardDocumentCheck', 10, 'بازرسی‌ها'],
    'CompanyInspectionResource' => ['بازرسی و ایمنی', 'ClipboardDocumentList', 20, 'بازدید شرکت‌ها'],
    'HazardAssessmentResource' => ['بازرسی و ایمنی', 'ExclamationTriangle', 30, 'ارزیابی خطر'],
    'EnvironmentalEstablishmentResource' => ['بازرسی و ایمنی', 'BuildingStorefront', 40, 'مؤسسات محیط'],
    'EnvironmentalInspectionResource' => ['بازرسی و ایمنی', 'MagnifyingGlass', 50, 'بازرسی محیط'],
    'HealthPermitResource' => ['بازرسی و ایمنی', 'CheckBadge', 60, 'مجوزهای بهداشتی'],
    'PestControlResource' => ['بازرسی و ایمنی', 'BugAnt', 70, 'مبارزه با آفات'],
    'OccupationalExaminationResource' => ['بازرسی و ایمنی', 'Clipboard', 80, 'معاینات شغلی'],

    // مالی
    'BudgetResource' => ['مالی و انبار', 'Banknotes', 10, 'بودجه‌ها'],
    'FinancialTransactionResource' => ['مالی و انبار', 'CurrencyDollar', 20, 'تراکنش‌های مالی'],
    'SupplyInventoryResource' => ['مالی و انبار', 'ArchiveBox', 30, 'موجودی انبار'],
    'VaccineDrugResource' => ['مالی و انبار', 'Beaker', 40, 'واکسن و دارو'],
    'VaccineDrugDistributionResource' => ['مالی و انبار', 'Truck', 50, 'توزیع واکسن/دارو'],
    'MedicalEquipmentResource' => ['مالی و انبار', 'Cube', 60, 'تجهیزات پزشکی'],
    'UtilityPaymentLogResource' => ['مالی و انبار', 'ReceiptPercent', 70, 'پرداخت انشعاب'],

    // فرم / گردش / امنیت
    'FormTemplateResource' => ['فرم‌ها', 'DocumentDuplicate', 10, 'قالب‌های فرم'],
    'FormSubmissionResource' => ['فرم‌ها', 'InboxArrowDown', 20, 'ارسال‌های فرم'],
    'ApprovalWorkflowResource' => ['گردش‌کار', 'ArrowsRightLeft', 10, 'گردش‌های تأیید'],
    'ApprovalRequestResource' => ['گردش‌کار', 'ClipboardDocumentCheck', 20, 'درخواست‌های تأیید'],
    'UserResource' => ['امنیت و دسترسی', 'UserCircle', 10, 'کاربران'],
    'RoleResource' => ['امنیت و دسترسی', 'UserGroup', 20, 'نقش‌ها'],
    'PermissionResource' => ['امنیت و دسترسی', 'LockClosed', 30, 'مجوزها'],
    'UserPermissionResource' => ['امنیت و دسترسی', 'FingerPrint', 40, 'مجوزهای کاربر'],
    'AccessLevelResource' => ['امنیت و دسترسی', 'ShieldCheck', 50, 'سطوح دسترسی'],
    'ManagerAccessLevelResource' => ['امنیت و دسترسی', 'Key', 60, 'دسترسی مدیران'],
    'UnitAccessRestrictionResource' => ['امنیت و دسترسی', 'NoSymbol', 70, 'محدودیت واحد'],
    'AccessChangeResource' => ['امنیت و دسترسی', 'ArrowPath', 80, 'تغییرات دسترسی'],
    'AccessReportResource' => ['امنیت و دسترسی', 'DocumentChartBar', 90, 'گزارش دسترسی'],
    'SecurityPolicyResource' => ['امنیت و دسترسی', 'DocumentCheck', 100, 'سیاست‌های امنیتی'],
    'SecurityIncidentResource' => ['امنیت و دسترسی', 'BellAlert', 110, 'حوادث امنیتی'],
    'SystemAlertResource' => ['امنیت و دسترسی', 'ExclamationCircle', 120, 'هشدارهای سیستم'],
];

// Validate icon names against enum
require $root . '/vendor/autoload.php';
$validIcons = [];
foreach (Filament\Support\Icons\Heroicon::cases() as $case) {
    $validIcons[$case->name] = true;
}

$groupOrder = [
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

$fixed = 0;
$files = glob($resourcesDir . '/*Resource.php');
foreach ($files as $file) {
    $base = basename($file, '.php');
    $code = file_get_contents($file);

    // Ensure Heroicon import
    if (! str_contains($code, 'use Filament\\Support\\Icons\\Heroicon;')) {
        $code = preg_replace(
            '/(namespace App\\\\Filament\\\\Resources;\s+)/',
            "$1\nuse Filament\\Support\\Icons\\Heroicon;\n",
            $code,
            1
        );
        // if namespace pattern different
        if (! str_contains($code, 'use Filament\\Support\\Icons\\Heroicon;')) {
            $code = str_replace(
                "namespace App\\Filament\\Resources;\n",
                "namespace App\\Filament\\Resources;\n\nuse Filament\\Support\\Icons\\Heroicon;\n",
                $code
            );
        }
    }

    $group = $map[$base][0] ?? 'سایر';
    $icon = $map[$base][1] ?? 'RectangleStack';
    $sortLocal = $map[$base][2] ?? 50;
    $label = $map[$base][3] ?? null;
    if (! isset($validIcons[$icon])) {
        // fallback
        $icon = 'RectangleStack';
    }
    $sort = ($groupOrder[$group] ?? 50) * 100 + $sortLocal;

    // Replace navigation properties
    $code = preg_replace(
        '/protected static \?string \$navigationLabel = .*?;/',
        $label ? "protected static ?string \$navigationLabel = '{$label}';" : '$0',
        $code,
        1
    );

    if (! preg_match('/protected static \?string \$navigationLabel/', $code) && $label) {
        $code = preg_replace(
            '/(protected static \?string \$pluralModelLabel = .*?;\s*)/',
            "$1\n    protected static ?string \$navigationLabel = '{$label}';\n",
            $code,
            1
        );
    }

    if (preg_match('/protected static string\|\\\\UnitEnum\|null \$navigationGroup = .*?;/', $code)) {
        $code = preg_replace(
            '/protected static string\|\\\\UnitEnum\|null \$navigationGroup = .*?;/',
            "protected static string|\\UnitEnum|null \$navigationGroup = '{$group}';",
            $code,
            1
        );
    } elseif (preg_match('/protected static string\|\\UnitEnum\|null \$navigationGroup = .*?;/', $code)) {
        $code = preg_replace(
            '/protected static string\|\\UnitEnum\|null \$navigationGroup = .*?;/',
            "protected static string|\\UnitEnum|null \$navigationGroup = '{$group}';",
            $code,
            1
        );
    } else {
        $code = preg_replace(
            '/(protected static \?string \$navigationLabel = .*?;\s*)/',
            "$1\n    protected static string|\\UnitEnum|null \$navigationGroup = '{$group}';\n",
            $code,
            1
        );
    }

    if (preg_match('/protected static string\|\\\\BackedEnum\|null \$navigationIcon = .*?;/', $code)
        || preg_match('/protected static string\|\\BackedEnum\|null \$navigationIcon = .*?;/', $code)
        || preg_match('/protected static \?string \$navigationIcon = .*?;/', $code)
        || preg_match('/protected static string\|\\\\BackedEnum\|null \$navigationIcon = .*?;/s', $code)) {
        $code = preg_replace(
            '/protected static (?:string\|\\\\BackedEnum\|null|\?string|string\|\\BackedEnum\|null) \$navigationIcon = .*?;/',
            "protected static string|\\BackedEnum|null \$navigationIcon = Heroicon::{$icon};",
            $code,
            1
        );
    } else {
        $code = preg_replace(
            '/(protected static string\|\\UnitEnum\|null \$navigationGroup = .*?;\s*)/',
            "$1\n    protected static string|\\BackedEnum|null \$navigationIcon = Heroicon::{$icon};\n",
            $code,
            1
        );
    }

    if (preg_match('/protected static \?int \$navigationSort = .*?;/', $code)) {
        $code = preg_replace(
            '/protected static \?int \$navigationSort = .*?;/',
            "protected static ?int \$navigationSort = {$sort};",
            $code,
            1
        );
    } else {
        $code = preg_replace(
            '/(protected static string\|\\BackedEnum\|null \$navigationIcon = .*?;\s*)/',
            "$1\n    protected static ?int \$navigationSort = {$sort};\n",
            $code,
            1
        );
    }

    // ensure shouldRegisterNavigation true (default)
    file_put_contents($file, $code);
    $fixed++;
}

echo "Patched {$fixed} resources\n";
