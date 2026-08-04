<?php

$root = dirname(__DIR__);
$files = glob($root . '/app/Filament/Resources/*Resource.php');

$nav = [
    'Center' => ['سازمان', 'BuildingOffice2', 10, 'مراکز'],
    'CenterType' => ['سازمان', 'Tag', 20, 'انواع مرکز'],
    'Company' => ['سازمان', 'Briefcase', 30, 'شرکت‌ها'],
    'OrganizationalUnit' => ['سازمان', 'BuildingLibrary', 40, 'واحدهای سازمانی'],
    'CenterRoom' => ['سازمان', 'HomeModern', 50, 'اتاق‌ها'],
    'CenterEquipment' => ['سازمان', 'CpuChip', 60, 'تجهیزات مراکز'],
    'CenterPhoneLine' => ['سازمان', 'Phone', 70, 'خطوط تلفن'],
    'CenterUtility' => ['سازمان', 'Bolt', 80, 'انشعابات'],
    'CenterBankAccount' => ['سازمان', 'CreditCard', 90, 'حساب‌های بانکی'],
    'CenterNetworkConnection' => ['سازمان', 'Signal', 100, 'اتصالات شبکه'],
    'CenterRelation' => ['سازمان', 'Share', 110, 'روابط مراکز'],
    'CenterClassification' => ['سازمان', 'Squares2X2', 120, 'طبقه‌بندی مراکز'],
    'OfficialCorrespondence' => ['سازمان', 'Envelope', 130, 'مکاتبات رسمی'],
    'Employee' => ['منابع انسانی', 'Users', 10, 'کارکنان'],
    'EmployeeContract' => ['منابع انسانی', 'DocumentText', 20, 'قراردادها'],
    'AttendanceRecord' => ['منابع انسانی', 'Clock', 30, 'حضور و غیاب'],
    'LeaveRecord' => ['منابع انسانی', 'CalendarDays', 40, 'مرخصی‌ها'],
    'PerformanceEvaluation' => ['منابع انسانی', 'ChartBarSquare', 50, 'ارزیابی عملکرد'],
    'StaffTransfer' => ['منابع انسانی', 'ArrowsUpDown', 60, 'انتقال پرسنل'],
    'EarlyRetirementCase' => ['منابع انسانی', 'Flag', 70, 'بازنشستگی پیش از موعد'],
    'FacilityRequest' => ['پشتیبانی و ناوگان', 'WrenchScrewdriver', 10, 'درخواست‌های تاسیسات'],
    'ItRequest' => ['پشتیبانی و ناوگان', 'ComputerDesktop', 20, 'درخواست‌های IT'],
    'VehicleRequest' => ['پشتیبانی و ناوگان', 'Map', 30, 'درخواست‌های خودرو'],
    'Vehicle' => ['پشتیبانی و ناوگان', 'Truck', 40, 'خودروها'],
    'Driver' => ['پشتیبانی و ناوگان', 'Identification', 50, 'رانندگان'],
    'VehicleTrip' => ['پشتیبانی و ناوگان', 'MapPin', 60, 'سفرهای خودرو'],
    'FuelRecord' => ['پشتیبانی و ناوگان', 'Fire', 70, 'سوابق سوخت'],
    'WorkOrder' => ['پشتیبانی و ناوگان', 'ClipboardDocumentList', 80, 'دستورهای کار'],
    'SimCard' => ['پشتیبانی و ناوگان', 'DevicePhoneMobile', 90, 'سیم‌کارت‌ها'],
    'VehicleMaintenance' => ['پشتیبانی و ناوگان', 'Cog6Tooth', 100, 'تعمیرات خودرو'],
    'TrainingMaterial' => ['آموزش', 'BookOpen', 10, 'محتوای آموزشی'],
    'TrainingDistribution' => ['آموزش', 'PaperAirplane', 20, 'توزیع آموزشی'],
    'TrainingServiceRecord' => ['آموزش', 'ClipboardDocument', 30, 'سوابق آموزش'],
    'PregnantWoman' => ['سلامت خانواده', 'Heart', 10, 'زنان باردار'],
    'MaternalHealth' => ['سلامت خانواده', 'Heart', 20, 'سلامت مادران'],
    'InfantChild' => ['سلامت خانواده', 'User', 30, 'نوزادان و کودکان'],
    'SchoolHealth' => ['سلامت خانواده', 'AcademicCap', 40, 'بهداشت مدارس'],
    'ElderlyCare' => ['سلامت خانواده', 'Heart', 50, 'مراقبت سالمندان'],
    'YouthHealth' => ['سلامت خانواده', 'Sparkles', 60, 'سلامت جوانان'],
    'Demographic' => ['سلامت خانواده', 'ChartBar', 70, 'اطلاعات جمعیتی'],
    'FamilyPlanning' => ['سلامت خانواده', 'Home', 80, 'تنظیم خانواده'],
    'DiseaseSurveillance' => ['سلامت و درمان', 'Beaker', 10, 'نظارت بیماری‌ها'],
    'ImmunizationRecord' => ['سلامت و درمان', 'ShieldCheck', 20, 'ایمن‌سازی'],
    'ChronicDiseaseTracking' => ['سلامت و درمان', 'Heart', 30, 'بیماری‌های مزمن'],
    'ThyroidScreening' => ['سلامت و درمان', 'Beaker', 40, 'غربالگری تیروئید'],
    'DentalService' => ['سلامت و درمان', 'FaceSmile', 50, 'خدمات دندانپزشکی'],
    'MentalHealthClinic' => ['سلامت و درمان', 'ChatBubbleLeftRight', 60, 'سلامت روان'],
    'Referral' => ['سلامت و درمان', 'ArrowTopRightOnSquare', 70, 'ارجاع‌ها'],
    'SuicideStatistic' => ['سلامت و درمان', 'PresentationChartLine', 80, 'آمار خودکشی'],
    'Inspection' => ['بازرسی و ایمنی', 'ClipboardDocumentCheck', 10, 'بازرسی‌ها'],
    'CompanyInspection' => ['بازرسی و ایمنی', 'ClipboardDocumentList', 20, 'بازدید شرکت‌ها'],
    'HazardAssessment' => ['بازرسی و ایمنی', 'ExclamationTriangle', 30, 'ارزیابی خطر'],
    'EnvironmentalEstablishment' => ['بازرسی و ایمنی', 'BuildingStorefront', 40, 'مؤسسات محیط'],
    'EnvironmentalInspection' => ['بازرسی و ایمنی', 'MagnifyingGlass', 50, 'بازرسی محیط'],
    'HealthPermit' => ['بازرسی و ایمنی', 'CheckBadge', 60, 'مجوزهای بهداشتی'],
    'PestControl' => ['بازرسی و ایمنی', 'BugAnt', 70, 'مبارزه با آفات'],
    'OccupationalExamination' => ['بازرسی و ایمنی', 'Clipboard', 80, 'معاینات شغلی'],
    'Budget' => ['مالی و انبار', 'Banknotes', 10, 'بودجه‌ها'],
    'FinancialTransaction' => ['مالی و انبار', 'CurrencyDollar', 20, 'تراکنش‌های مالی'],
    'SupplyInventory' => ['مالی و انبار', 'ArchiveBox', 30, 'موجودی انبار'],
    'VaccineDrug' => ['مالی و انبار', 'Beaker', 40, 'واکسن و دارو'],
    'VaccineDrugDistribution' => ['مالی و انبار', 'Truck', 50, 'توزیع واکسن/دارو'],
    'MedicalEquipment' => ['مالی و انبار', 'Cube', 60, 'تجهیزات پزشکی'],
    'UtilityPaymentLog' => ['مالی و انبار', 'ReceiptPercent', 70, 'پرداخت انشعاب'],
    'FormTemplate' => ['فرم‌ها', 'DocumentDuplicate', 10, 'قالب‌های فرم'],
    'FormSubmission' => ['فرم‌ها', 'InboxArrowDown', 20, 'ارسال‌های فرم'],
    'ApprovalWorkflow' => ['گردش‌کار', 'ArrowsRightLeft', 10, 'گردش‌های تأیید'],
    'ApprovalRequest' => ['گردش‌کار', 'ClipboardDocumentCheck', 20, 'درخواست‌های تأیید'],
    'User' => ['امنیت و دسترسی', 'UserCircle', 10, 'کاربران'],
    'Role' => ['امنیت و دسترسی', 'UserGroup', 20, 'نقش‌ها'],
    'Permission' => ['امنیت و دسترسی', 'LockClosed', 30, 'مجوزها'],
    'UserPermission' => ['امنیت و دسترسی', 'FingerPrint', 40, 'مجوزهای کاربر'],
    'AccessLevel' => ['امنیت و دسترسی', 'ShieldCheck', 50, 'سطوح دسترسی'],
    'ManagerAccessLevel' => ['امنیت و دسترسی', 'Key', 60, 'دسترسی مدیران'],
    'UnitAccessRestriction' => ['امنیت و دسترسی', 'NoSymbol', 70, 'محدودیت واحد'],
    'AccessChange' => ['امنیت و دسترسی', 'ArrowPath', 80, 'تغییرات دسترسی'],
    'AccessReport' => ['امنیت و دسترسی', 'DocumentChartBar', 90, 'گزارش دسترسی'],
    'SecurityPolicy' => ['امنیت و دسترسی', 'DocumentCheck', 100, 'سیاست‌های امنیتی'],
    'SecurityIncident' => ['امنیت و دسترسی', 'BellAlert', 110, 'حوادث امنیتی'],
    'SystemAlert' => ['امنیت و دسترسی', 'ExclamationCircle', 120, 'هشدارهای سیستم'],
];

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
    'سایر' => 99,
];

function replaceOrInsert(string $code, string $pattern, string $replacement, string $afterPattern): string
{
    if (preg_match($pattern, $code)) {
        return preg_replace($pattern, $replacement, $code, 1);
    }

    return preg_replace($afterPattern, '$0' . "\n\n    {$replacement}", $code, 1);
}

$fixed = 0;
foreach ($files as $file) {
    $short = basename($file, 'Resource.php');
    [$group, $icon, $local, $label] = $nav[$short] ?? ['سایر', 'RectangleStack', 50, $short];
    $sort = ($groupOrder[$group] ?? 50) * 100 + $local;

    $code = file_get_contents($file);

    if (! str_contains($code, 'use Filament\\Support\\Icons\\Heroicon;')) {
        $code = str_replace(
            "namespace App\\Filament\\Resources;\n",
            "namespace App\\Filament\\Resources;\n\nuse Filament\\Support\\Icons\\Heroicon;\n",
            $code
        );
    }

    $code = replaceOrInsert(
        $code,
        '/protected static \?string \$navigationLabel = .*?;/',
        "protected static ?string \$navigationLabel = '{$label}';",
        '/protected static \?string \$model = .*?;/'
    );

    $code = replaceOrInsert(
        $code,
        '/protected static string\|\\\\?UnitEnum\|null \$navigationGroup = .*?;/',
        "protected static string|\\UnitEnum|null \$navigationGroup = '{$group}';",
        '/protected static \?string \$navigationLabel = .*?;/'
    );

    $code = replaceOrInsert(
        $code,
        '/protected static (?:string\|\\\\?BackedEnum\|null|\?string) \$navigationIcon = .*?;/',
        "protected static string|\\BackedEnum|null \$navigationIcon = Heroicon::{$icon};",
        '/protected static string\|\\\\?UnitEnum\|null \$navigationGroup = .*?;/'
    );

    $code = replaceOrInsert(
        $code,
        '/protected static \?int \$navigationSort = .*?;/',
        "protected static ?int \$navigationSort = {$sort};",
        '/protected static string\|\\\\?BackedEnum\|null \$navigationIcon = .*?;/'
    );

    if (! str_contains($code, 'function shouldRegisterNavigation')) {
        $code = preg_replace(
            '/protected static \?int \$navigationSort = .*?;/',
            "protected static ?int \$navigationSort = {$sort};\n\n    public static function shouldRegisterNavigation(): bool\n    {\n        return true;\n    }",
            $code,
            1
        );
    }

    file_put_contents($file, $code);
    $fixed++;
}

echo "patched {$fixed}\n";
