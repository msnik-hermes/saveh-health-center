<?php

/**
 * Premium Filament resource generator for Saveh Health Center.
 * php scripts/generate_filament_resources_v2.php
 */

$root = dirname(__DIR__);
$meta = json_decode(file_get_contents($root . '/storage/app/models_meta.json'), true);
if (! is_array($meta) || $meta === []) {
    fwrite(STDERR, "models_meta.json missing/empty. Run scripts/export_models_meta.php first.\n");
    exit(1);
}

$skip = [
    'RolePermission',
    'UserRole',
    'EncryptionKey',
    'DigitalCertificate',
    'ActiveSession',
    'ApiLog',
    'AuditLog',
    'BackupLog',
    'UserLoginLog',
    'NetworkMonitoringLog',
    'ActivityLog',
];

// Include User as admin-manageable (no password required on edit via dehydrated)
$labels = [
    'User' => ['کاربر', 'کاربران', 'امنیت و دسترسی', 'heroicon-o-user-circle'],
    'AccessChange' => ['تغییر دسترسی', 'تغییرات دسترسی', 'امنیت و دسترسی', 'heroicon-o-arrow-path'],
    'AccessLevel' => ['سطح دسترسی', 'سطوح دسترسی', 'امنیت و دسترسی', 'heroicon-o-shield-check'],
    'AccessReport' => ['گزارش دسترسی', 'گزارش‌های دسترسی', 'امنیت و دسترسی', 'heroicon-o-document-chart-bar'],
    'ApprovalRequest' => ['درخواست تأیید', 'درخواست‌های تأیید', 'گردش‌کار', 'heroicon-o-clipboard-document-check'],
    'ApprovalWorkflow' => ['گردش تأیید', 'گردش‌های تأیید', 'گردش‌کار', 'heroicon-o-arrows-right-left'],
    'AttendanceRecord' => ['حضور و غیاب', 'سوابق حضور', 'منابع انسانی', 'heroicon-o-clock'],
    'Budget' => ['بودجه', 'بودجه‌ها', 'مالی و انبار', 'heroicon-o-banknotes'],
    'Center' => ['مرکز', 'مراکز', 'سازمان', 'heroicon-o-building-office-2'],
    'CenterBankAccount' => ['حساب بانکی مرکز', 'حساب‌های بانکی', 'سازمان', 'heroicon-o-credit-card'],
    'CenterClassification' => ['طبقه‌بندی مرکز', 'طبقه‌بندی مراکز', 'سازمان', 'heroicon-o-tag'],
    'CenterEquipment' => ['تجهیزات مرکز', 'تجهیزات مراکز', 'سازمان', 'heroicon-o-cpu-chip'],
    'CenterNetworkConnection' => ['اتصال شبکه', 'اتصالات شبکه', 'سازمان', 'heroicon-o-signal'],
    'CenterPhoneLine' => ['خط تلفن مرکز', 'خطوط تلفن', 'سازمان', 'heroicon-o-phone'],
    'CenterRelation' => ['رابطه مراکز', 'روابط مراکز', 'سازمان', 'heroicon-o-share'],
    'CenterRoom' => ['اتاق مرکز', 'اتاق‌ها', 'سازمان', 'heroicon-o-home-modern'],
    'CenterType' => ['نوع مرکز', 'انواع مرکز', 'سازمان', 'heroicon-o-squares-2x2'],
    'CenterUtility' => ['انشعاب مرکز', 'انشعابات', 'سازمان', 'heroicon-o-bolt'],
    'ChronicDiseaseTracking' => ['بیماری مزمن', 'ردیابی بیماری‌های مزمن', 'سلامت و درمان', 'heroicon-o-heart'],
    'Company' => ['شرکت', 'شرکت‌ها', 'سازمان', 'heroicon-o-briefcase'],
    'CompanyInspection' => ['بازدید شرکت', 'بازدیدهای شرکت', 'بازرسی و ایمنی', 'heroicon-o-clipboard-document-list'],
    'Demographic' => ['جمعیت', 'اطلاعات جمعیتی', 'سلامت خانواده', 'heroicon-o-chart-bar'],
    'DentalService' => ['خدمت دندان', 'خدمات دندانپزشکی', 'سلامت و درمان', 'heroicon-o-face-smile'],
    'DiseaseSurveillance' => ['نظارت بیماری', 'نظارت بیماری‌ها', 'سلامت و درمان', 'heroicon-o-beaker'],
    'Driver' => ['راننده', 'رانندگان', 'پشتیبانی و ناوگان', 'heroicon-o-identification'],
    'EarlyRetirementCase' => ['بازنشستگی پیش از موعد', 'موارد بازنشستگی', 'منابع انسانی', 'heroicon-o-flag'],
    'ElderlyCare' => ['مراقبت سالمند', 'مراقبت سالمندان', 'سلامت خانواده', 'heroicon-o-heart'],
    'Employee' => ['کارمند', 'کارکنان', 'منابع انسانی', 'heroicon-o-users'],
    'EmployeeContract' => ['قرارداد پرسنل', 'قراردادها', 'منابع انسانی', 'heroicon-o-document-text'],
    'EnvironmentalEstablishment' => ['مؤسسه محیطی', 'مؤسسات بهداشت محیط', 'بازرسی و ایمنی', 'heroicon-o-building-storefront'],
    'EnvironmentalInspection' => ['بازرسی محیط', 'بازرسی‌های بهداشت محیط', 'بازرسی و ایمنی', 'heroicon-o-magnifying-glass'],
    'FacilityRequest' => ['درخواست تاسیسات', 'درخواست‌های تاسیسات', 'پشتیبانی و ناوگان', 'heroicon-o-wrench-screwdriver'],
    'FamilyPlanning' => ['تنظیم خانواده', 'تنظیم خانواده', 'سلامت خانواده', 'heroicon-o-home'],
    'FinancialTransaction' => ['تراکنش مالی', 'تراکنش‌های مالی', 'مالی و انبار', 'heroicon-o-currency-dollar'],
    'FormSubmission' => ['ارسال فرم', 'ارسال‌های فرم', 'فرم‌ها', 'heroicon-o-inbox-arrow-down'],
    'FormTemplate' => ['قالب فرم', 'قالب‌های فرم', 'فرم‌ها', 'heroicon-o-document-duplicate'],
    'FuelRecord' => ['سوخت', 'سوابق سوخت', 'پشتیبانی و ناوگان', 'heroicon-o-fire'],
    'HazardAssessment' => ['ارزیابی خطر', 'ارزیابی‌های خطر', 'بازرسی و ایمنی', 'heroicon-o-exclamation-triangle'],
    'HealthPermit' => ['مجوز بهداشتی', 'مجوزهای بهداشتی', 'بازرسی و ایمنی', 'heroicon-o-check-badge'],
    'ImmunizationRecord' => ['واکسیناسیون', 'سوابق ایمن‌سازی', 'سلامت و درمان', 'heroicon-o-shield-check'],
    'InfantChild' => ['نوزاد/کودک', 'نوزادان و کودکان', 'سلامت خانواده', 'heroicon-o-user'],
    'Inspection' => ['بازرسی', 'بازرسی‌ها', 'بازرسی و ایمنی', 'heroicon-o-clipboard-document-check'],
    'ItRequest' => ['درخواست IT', 'درخواست‌های IT', 'پشتیبانی و ناوگان', 'heroicon-o-computer-desktop'],
    'LeaveRecord' => ['مرخصی', 'سوابق مرخصی', 'منابع انسانی', 'heroicon-o-calendar-days'],
    'ManagerAccessLevel' => ['دسترسی مدیر', 'دسترسی مدیران', 'امنیت و دسترسی', 'heroicon-o-key'],
    'MaternalHealth' => ['سلامت مادر', 'سلامت مادران', 'سلامت خانواده', 'heroicon-o-heart'],
    'MedicalEquipment' => ['تجهیز پزشکی', 'تجهیزات پزشکی', 'مالی و انبار', 'heroicon-o-cube'],
    'MentalHealthClinic' => ['کلینیک سلامت روان', 'کلینیک‌های سلامت روان', 'سلامت و درمان', 'heroicon-o-chat-bubble-left-right'],
    'OccupationalExamination' => ['معاینه شغلی', 'معاینات شغلی', 'بازرسی و ایمنی', 'heroicon-o-clipboard'],
    'OfficialCorrespondence' => ['مکاتبه رسمی', 'مکاتبات رسمی', 'سازمان', 'heroicon-o-envelope'],
    'OrganizationalUnit' => ['واحد سازمانی', 'واحدهای سازمانی', 'سازمان', 'heroicon-o-building-library'],
    'PerformanceEvaluation' => ['ارزیابی عملکرد', 'ارزیابی‌های عملکرد', 'منابع انسانی', 'heroicon-o-chart-bar-square'],
    'Permission' => ['مجوز', 'مجوزها', 'امنیت و دسترسی', 'heroicon-o-lock-closed'],
    'PestControl' => ['مبارزه با آفات', 'مبارزه با آفات', 'بازرسی و ایمنی', 'heroicon-o-bug-ant'],
    'PregnantWoman' => ['زن باردار', 'زنان باردار', 'سلامت خانواده', 'heroicon-o-heart'],
    'Referral' => ['ارجاع', 'ارجاع‌ها', 'سلامت و درمان', 'heroicon-o-arrow-top-right-on-square'],
    'Role' => ['نقش', 'نقش‌ها', 'امنیت و دسترسی', 'heroicon-o-user-group'],
    'SchoolHealth' => ['بهداشت مدارس', 'بهداشت مدارس', 'سلامت خانواده', 'heroicon-o-academic-cap'],
    'SecurityIncident' => ['حادثه امنیتی', 'حوادث امنیتی', 'امنیت و دسترسی', 'heroicon-o-bell-alert'],
    'SecurityPolicy' => ['سیاست امنیتی', 'سیاست‌های امنیتی', 'امنیت و دسترسی', 'heroicon-o-document-check'],
    'SimCard' => ['سیم‌کارت', 'سیم‌کارت‌ها', 'پشتیبانی و ناوگان', 'heroicon-o-device-phone-mobile'],
    'StaffTransfer' => ['انتقال پرسنل', 'انتقال‌های پرسنل', 'منابع انسانی', 'heroicon-o-arrows-up-down'],
    'SuicideStatistic' => ['آمار خودکشی', 'آمار خودکشی', 'سلامت و درمان', 'heroicon-o-presentation-chart-line'],
    'SupplyInventory' => ['موجودی انبار', 'موجودی انبار', 'مالی و انبار', 'heroicon-o-archive-box'],
    'SystemAlert' => ['هشدار سیستم', 'هشدارهای سیستم', 'امنیت و دسترسی', 'heroicon-o-exclamation-circle'],
    'ThyroidScreening' => ['غربالگری تیروئید', 'غربالگری تیروئید', 'سلامت و درمان', 'heroicon-o-beaker'],
    'TrainingDistribution' => ['توزیع آموزش', 'توزیع‌های آموزشی', 'آموزش', 'heroicon-o-paper-airplane'],
    'TrainingMaterial' => ['محتوای آموزشی', 'محتوای آموزشی', 'آموزش', 'heroicon-o-book-open'],
    'TrainingServiceRecord' => ['خدمت آموزشی', 'سوابق خدمات آموزشی', 'آموزش', 'heroicon-o-clipboard-document'],
    'UnitAccessRestriction' => ['محدودیت واحد', 'محدودیت‌های واحد', 'امنیت و دسترسی', 'heroicon-o-no-symbol'],
    'UserPermission' => ['مجوز کاربر', 'مجوزهای کاربر', 'امنیت و دسترسی', 'heroicon-o-finger-print'],
    'UtilityPaymentLog' => ['پرداخت انشعاب', 'پرداخت‌های انشعاب', 'مالی و انبار', 'heroicon-o-receipt-percent'],
    'VaccineDrug' => ['واکسن/دارو', 'واکسن‌ها و داروها', 'مالی و انبار', 'heroicon-o-beaker'],
    'VaccineDrugDistribution' => ['توزیع واکسن/دارو', 'توزیع واکسن و دارو', 'مالی و انبار', 'heroicon-o-truck'],
    'Vehicle' => ['خودرو', 'خودروها', 'پشتیبانی و ناوگان', 'heroicon-o-truck'],
    'VehicleMaintenance' => ['تعمیر خودرو', 'تعمیرات خودرو', 'پشتیبانی و ناوگان', 'heroicon-o-cog-6-tooth'],
    'VehicleRequest' => ['درخواست خودرو', 'درخواست‌های خودرو', 'پشتیبانی و ناوگان', 'heroicon-o-map'],
    'VehicleTrip' => ['سفر خودرو', 'سفرهای خودرو', 'پشتیبانی و ناوگان', 'heroicon-o-map-pin'],
    'WorkOrder' => ['دستور کار', 'دستورهای کار', 'پشتیبانی و ناوگان', 'heroicon-o-clipboard-document-list'],
    'YouthHealth' => ['سلامت جوانان', 'سلامت جوانان', 'سلامت خانواده', 'heroicon-o-sparkles'],
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
    'سایر' => 99,
];

$skipColumns = [
    'id', 'created_at', 'updated_at', 'deleted_at', 'remember_token',
    'email_verified_at', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at',
];

// Global field label dictionary (common DB columns in this project)
$fieldLabels = [
    'name' => 'نام', 'title' => 'عنوان', 'code' => 'کد', 'status' => 'وضعیت', 'type' => 'نوع',
    'phone' => 'تلفن', 'mobile' => 'موبایل', 'email' => 'ایمیل', 'address' => 'آدرس',
    'city' => 'شهر', 'province' => 'استان', 'district' => 'منطقه', 'description' => 'توضیحات',
    'notes' => 'یادداشت', 'center_id' => 'مرکز', 'company_id' => 'شرکت', 'employee_id' => 'کارمند',
    'user_id' => 'کاربر', 'role_id' => 'نقش', 'permission_id' => 'مجوز', 'vehicle_id' => 'خودرو',
    'driver_id' => 'راننده', 'parent_id' => 'مرکز والد', 'is_active' => 'فعال', 'amount' => 'مبلغ',
    'date' => 'تاریخ', 'start_date' => 'تاریخ شروع', 'end_date' => 'تاریخ پایان',
    'request_date' => 'تاریخ درخواست', 'national_id' => 'کد ملی', 'registration_number' => 'شماره ثبت',
    'priority' => 'اولویت', 'level' => 'سطح', 'gender' => 'جنسیت', 'birth_date' => 'تاریخ تولد',
    'first_name' => 'نام', 'last_name' => 'نام خانوادگی', 'full_name' => 'نام کامل',
    'fax' => 'فکس', 'website' => 'وب‌سایت', 'postal_code' => 'کد پستی', 'capacity' => 'ظرفیت',
    'quantity' => 'تعداد', 'unit' => 'واحد', 'price' => 'قیمت', 'total' => 'جمع',
    'year' => 'سال', 'month' => 'ماه', 'reason' => 'دلیل', 'result' => 'نتیجه', 'score' => 'امتیاز',
    'location' => 'مکان', 'plate_number' => 'پلاک', 'serial_number' => 'شماره سریال',
    'license_number' => 'شماره مجوز', 'requested_by' => 'درخواست‌کننده', 'approved_by' => 'تأییدکننده',
    'created_by' => 'ایجادکننده', 'updated_by' => 'ویرایش‌کننده', 'password' => 'رمز عبور',
    'university' => 'دانشگاه', 'gps_lat' => 'عرض جغرافیایی', 'gps_lng' => 'طول جغرافیایی',
    'population_served' => 'جمعیت تحت پوشش', 'service_area_type' => 'نوع حوزه خدمت',
    'area_sqm' => 'مساحت (م²)', 'floors' => 'تعداد طبقات', 'rooms_count' => 'تعداد اتاق',
    'parking_spaces' => 'پارکینگ', 'has_elevator' => 'آسانسور', 'has_generator' => 'ژنراتور',
    'generator_power_kw' => 'قدرت ژنراتور (کیلووات)', 'has_fire_system' => 'سیستم آتش‌نشانی',
    'has_cctv' => 'دوربین مداربسته', 'building_type' => 'نوع ساختمان', 'established_date' => 'تاریخ تأسیس',
    'license_expiry' => 'انقضای مجوز', 'accreditation_level' => 'سطح اعتباربخشی',
    'working_hours_start' => 'ساعت شروع', 'working_hours_end' => 'ساعت پایان',
    'working_days' => 'روزهای کاری', 'emergency_hours' => 'ساعات اضطراری', 'logo' => 'لوگو',
    'supervisor_id' => 'سرپرست', 'personnel_code' => 'کد پرسنلی', 'father_name' => 'نام پدر',
    'birth_place' => 'محل تولد', 'marital_status' => 'وضعیت تأهل', 'education' => 'تحصیلات',
    'field_of_study' => 'رشته', 'job_title' => 'سمت', 'employment_type' => 'نوع استخدام',
    'hire_date' => 'تاریخ استخدام', 'contract_end_date' => 'پایان قرارداد',
    'insurance_number' => 'شماره بیمه', 'bank_account' => 'شماره حساب', 'iban' => 'شبا',
    'emergency_contact' => 'تماس اضطراری', 'emergency_phone' => 'تلفن اضطراری',
    'disease_name' => 'نام بیماری', 'disease_code' => 'کد بیماری', 'disease_category' => 'دسته بیماری',
    'report_date' => 'تاریخ گزارش', 'onset_date' => 'تاریخ شروع علائم', 'patient_age' => 'سن بیمار',
    'patient_gender' => 'جنسیت بیمار', 'patient_occupation' => 'شغل بیمار',
    'residence_location' => 'محل سکونت', 'infection_location' => 'محل ابتلا',
    'symptoms' => 'علائم', 'lab_confirmed' => 'تأیید آزمایشگاهی', 'lab_result' => 'نتیجه آزمایش',
    'severity' => 'شدت', 'treatment' => 'درمان', 'outcome' => 'پیامد',
    'contacts_identified' => 'مخاطبین شناسایی‌شده', 'contact_tracing_done' => 'ردیابی مخاطب',
    'isolation_applied' => 'قرنطینه', 'report_source' => 'منبع گزارش', 'follow_up_status' => 'وضعیت پیگیری',
    'case_id' => 'شناسه پرونده', 'facility_type' => 'نوع تاسیسات', 'preferred_time' => 'زمان ترجیحی',
    'budget_approval' => 'تأیید بودجه', 'images' => 'تصاویر', 'assigned_to' => 'واگذار به',
    'completion_date' => 'تاریخ تکمیل', 'cost' => 'هزینه', 'inspector_id' => 'بازرس',
    'inspection_date' => 'تاریخ بازرسی', 'inspection_type' => 'نوع بازرسی',
    'findings' => 'یافته‌ها', 'recommendations' => 'توصیه‌ها', 'score_total' => 'امتیاز کل',
    'risk_level' => 'سطح خطر', 'category' => 'دسته', 'subject' => 'موضوع', 'body' => 'متن',
    'content' => 'محتوا', 'message' => 'پیام', 'is_granted' => 'اعطا شده', 'expires_at' => 'انقضا',
    'granted_by' => 'اعطاکننده', 'display_name' => 'نام نمایشی', 'slug' => 'شناسه یکتا',
    'model_type' => 'نوع مدل', 'model_id' => 'شناسه مدل', 'tokenable_type' => 'نوع توکن',
    'tokenable_id' => 'شناسه توکن', 'abilities' => 'توانایی‌ها', 'last_used_at' => 'آخرین استفاده',
    'ip_address' => 'آدرس IP', 'user_agent' => 'مرورگر', 'payload' => 'داده',
    'request_type' => 'نوع درخواست', 'destination' => 'مقصد', 'origin' => 'مبدأ',
    'fuel_type' => 'نوع سوخت', 'odometer' => 'کیلومترشمار', 'brand' => 'برند', 'model' => 'مدل',
    'color' => 'رنگ', 'year_made' => 'سال ساخت', 'chassis_number' => 'شماره شاسی',
    'engine_number' => 'شماره موتور', 'owner_name' => 'نام مالک', 'owner_national_id' => 'کد ملی مالک',
    'gestational_age' => 'سن بارداری', 'lmp_date' => 'تاریخ LMP', 'edd_date' => 'تاریخ زایمان تقریبی',
    'pregnancy_number' => 'تعداد بارداری', 'live_births' => 'زایمان زنده', 'blood_type' => 'گروه خونی',
    'rh' => 'RH', 'risk_factors' => 'عوامل خطر', 'visit_date' => 'تاریخ ویزیت',
    'next_visit_date' => 'ویزیت بعدی', 'weight' => 'وزن', 'height' => 'قد', 'bmi' => 'BMI',
    'blood_pressure' => 'فشار خون', 'temperature' => 'دما', 'vaccine_name' => 'نام واکسن',
    'dose_number' => 'شماره دوز', 'batch_number' => 'شماره بچ', 'manufacturer' => 'تولیدکننده',
    'expiry_date' => 'تاریخ انقضا', 'administered_by' => 'تزریق‌کننده', 'site' => 'محل تزریق',
    'reaction' => 'واکنش', 'school_name' => 'نام مدرسه', 'grade' => 'پایه', 'class_name' => 'کلاس',
    'student_count' => 'تعداد دانش‌آموز', 'screening_date' => 'تاریخ غربالگری',
    'positive_cases' => 'موارد مثبت', 'referred_cases' => 'موارد ارجاع',
    'organization_id' => 'سازمان', 'unit_id' => 'واحد', 'workflow_id' => 'گردش‌کار',
    'current_step' => 'مرحله فعلی', 'requester_id' => 'درخواست‌دهنده', 'approver_id' => 'تأییدکننده',
    'decision' => 'تصمیم', 'comment' => 'نظر', 'started_at' => 'شروع', 'finished_at' => 'پایان',
    'is_required' => 'الزامی', 'sort_order' => 'ترتیب', 'meta' => 'متاداده', 'settings' => 'تنظیمات',
    'config' => 'پیکربندی', 'data' => 'داده', 'value' => 'مقدار', 'key' => 'کلید',
    'balance' => 'مانده', 'debit' => 'بدهکار', 'credit' => 'بستانکار', 'currency' => 'ارز',
    'reference_no' => 'شماره پیگیری', 'invoice_no' => 'شماره فاکتور', 'supplier' => 'تأمین‌کننده',
    'warehouse' => 'انبار', 'min_stock' => 'حداقل موجودی', 'max_stock' => 'حداکثر موجودی',
    'reorder_level' => 'نقطه سفارش', 'unit_price' => 'قیمت واحد', 'total_price' => 'قیمت کل',
    'attachment' => 'پیوست', 'file_path' => 'مسیر فایل', 'mime_type' => 'نوع فایل',
    'size' => 'حجم', 'checksum' => 'چک‌سام', 'version' => 'نسخه', 'is_default' => 'پیش‌فرض',
    'is_public' => 'عمومی', 'is_enabled' => 'فعال‌سازی', 'enabled' => 'فعال',
    'disabled_at' => 'تاریخ غیرفعال', 'published_at' => 'تاریخ انتشار',
    'archived_at' => 'بایگانی', 'closed_at' => 'بسته شده در', 'opened_at' => 'باز شده در',
    'scheduled_at' => 'زمان‌بندی', 'due_date' => 'سررسید', 'assigned_at' => 'واگذاری',
    'resolved_at' => 'حل شده در', 'resolution' => 'راه‌حل', 'severity_score' => 'امتیاز شدت',
    'probability' => 'احتمال', 'impact' => 'اثر', 'control_measures' => 'اقدامات کنترلی',
    'residual_risk' => 'ریسک باقیمانده', 'owner_id' => 'مالک', 'manager_id' => 'مدیر',
    'department' => 'بخش', 'section' => 'قسمت', 'shift' => 'شیفت', 'room_number' => 'شماره اتاق',
    'floor' => 'طبقه', 'building' => 'ساختمان', 'account_number' => 'شماره حساب',
    'bank_name' => 'نام بانک', 'branch_name' => 'شعبه', 'sheba' => 'شبا',
    'card_number' => 'شماره کارت', 'line_number' => 'شماره خط', 'provider' => 'اپراتور',
    'plan' => 'طرح', 'bandwidth' => 'پهنای باند', 'ip' => 'IP', 'mac_address' => 'MAC',
    'ssid' => 'SSID', 'connection_type' => 'نوع اتصال', 'utility_type' => 'نوع انشعاب',
    'meter_number' => 'شماره کنتور', 'subscription_number' => 'شماره اشتراک',
    'reading' => 'قرائت', 'previous_reading' => 'قرائت قبلی', 'consumption' => 'مصرف',
    'bill_amount' => 'مبلغ قبض', 'payment_date' => 'تاریخ پرداخت', 'payment_method' => 'روش پرداخت',
    'payment_ref' => 'پیگیری پرداخت', 'from_center_id' => 'از مرکز', 'to_center_id' => 'به مرکز',
    'relation_type' => 'نوع رابطه', 'classification' => 'طبقه‌بندی', 'grade_level' => 'سطح',
    'equipment_name' => 'نام تجهیز', 'equipment_type' => 'نوع تجهیز', 'asset_tag' => 'برچسب اموال',
    'purchase_date' => 'تاریخ خرید', 'warranty_expiry' => 'پایان گارانتی', 'custodian_id' => 'تحویل‌گیرنده',
    'condition' => 'وضعیت فنی', 'maintenance_date' => 'تاریخ سرویس', 'next_maintenance' => 'سرویس بعدی',
    'trip_date' => 'تاریخ سفر', 'distance_km' => 'مسافت (کیلومتر)', 'purpose' => 'هدف',
    'passengers' => 'مسافران', 'fuel_liters' => 'لیتر سوخت', 'fuel_cost' => 'هزینه سوخت',
    'maintenance_type' => 'نوع تعمیر', 'parts_cost' => 'هزینه قطعات', 'labor_cost' => 'هزینه اجرت',
    'vendor' => 'پیمانکار', 'invoice_number' => 'شماره فاکتور', 'work_order_no' => 'شماره دستور کار',
    'technician_id' => 'تکنسین', 'estimated_hours' => 'ساعت برآوردی', 'actual_hours' => 'ساعت واقعی',
    'materials' => 'مواد', 'checklist' => 'چک‌لیست', 'template_id' => 'قالب', 'form_data' => 'داده فرم',
    'submitted_by' => 'ارسال‌کننده', 'submitted_at' => 'زمان ارسال', 'reviewed_by' => 'بازبین',
    'reviewed_at' => 'زمان بازبینی', 'review_notes' => 'یادداشت بازبینی',
    'workflow_name' => 'نام گردش', 'steps' => 'مراحل', 'is_sequential' => 'ترتیبی',
    'min_approvals' => 'حداقل تأیید', 'current_status' => 'وضعیت جاری',
    'alert_type' => 'نوع هشدار', 'alert_level' => 'سطح هشدار', 'is_read' => 'خوانده شده',
    'read_at' => 'زمان خواندن', 'source' => 'منبع', 'target' => 'هدف',
    'action' => 'اقدام', 'old_values' => 'مقادیر قبلی', 'new_values' => 'مقادیر جدید',
    'entity_type' => 'نوع موجودیت', 'entity_id' => 'شناسه موجودیت',
    'policy_name' => 'نام سیاست', 'policy_body' => 'متن سیاست', 'effective_date' => 'تاریخ اجرا',
    'review_date' => 'تاریخ بازنگری', 'owner_unit' => 'واحد مالک',
    'incident_type' => 'نوع حادثه', 'incident_date' => 'تاریخ حادثه', 'reported_by' => 'گزارش‌دهنده',
    'severity_level' => 'سطح شدت', 'affected_systems' => 'سامانه‌های درگیر',
    'containment' => 'مهار', 'root_cause' => 'علت ریشه‌ای', 'lessons_learned' => 'درس‌آموخته',
    'permission_name' => 'نام مجوز', 'role_name' => 'نام نقش', 'guard_name' => 'گارد',
    'is_system' => 'سیستمی', 'can_create' => 'ایجاد', 'can_read' => 'مشاهده',
    'can_update' => 'ویرایش', 'can_delete' => 'حذف', 'scope' => 'دامنه',
    'center_code' => 'کد مرکز', 'employee_code' => 'کد کارمند',
    'national_code' => 'کد ملی', 'passport_no' => 'شماره گذرنامه',
    'medical_record_no' => 'شماره پرونده پزشکی', 'file_no' => 'شماره پرونده',
    'family_members' => 'اعضای خانواده', 'household_size' => 'بعد خانوار',
    'income_level' => 'سطح درآمد', 'insurance_type' => 'نوع بیمه',
    'coverage' => 'پوشش', 'clinic_name' => 'نام کلینیک', 'session_count' => 'تعداد جلسه',
    'diagnosis' => 'تشخیص', 'prescription' => 'نسخه', 'follow_up' => 'پیگیری',
    'referral_to' => 'ارجاع به', 'referral_from' => 'ارجاع از', 'referral_reason' => 'علت ارجاع',
    'referral_date' => 'تاریخ ارجاع', 'accepted' => 'پذیرش', 'rejected_reason' => 'علت رد',
    'school_type' => 'نوع مدرسه', 'urban_rural' => 'شهری/روستایی',
    'hygiene_score' => 'امتیاز بهداشت', 'nutrition_status' => 'وضعیت تغذیه',
    'oral_health' => 'سلامت دهان', 'vision_screening' => 'بینایی‌سنجی',
    'hearing_screening' => 'شنوایی‌سنجی', 'mental_health_flag' => 'پرچم سلامت روان',
    'care_plan' => 'برنامه مراقبت', 'caregiver' => 'مراقب', 'dependency_level' => 'سطح وابستگی',
    'mobility' => 'تحرک', 'chronic_conditions' => 'بیماری‌های مزمن',
    'medication' => 'دارو', 'last_visit' => 'آخرین ویزیت', 'next_visit' => 'ویزیت بعدی',
    'youth_group' => 'گروه سنی', 'risk_behavior' => 'رفتار پرخطر', 'counseling' => 'مشاوره',
    'education_session' => 'جلسه آموزشی', 'attendance' => 'حضور',
    'material_title' => 'عنوان محتوا', 'material_type' => 'نوع محتوا', 'audience' => 'مخاطب',
    'language' => 'زبان', 'pages' => 'صفحات', 'distributed_count' => 'تعداد توزیع',
    'distribution_date' => 'تاریخ توزیع', 'receiver' => 'گیرنده', 'channel' => 'کانال',
    'service_type' => 'نوع خدمت', 'service_date' => 'تاریخ خدمت', 'provider_name' => 'ارائه‌دهنده',
    'participants' => 'شرکت‌کنندگان', 'duration_minutes' => 'مدت (دقیقه)',
    'satisfaction' => 'رضایت', 'feedback' => 'بازخورد',
    'exam_type' => 'نوع معاینه', 'exam_date' => 'تاریخ معاینه', 'fitness' => 'صلاحیت کاری',
    'restrictions' => 'محدودیت‌ها', 'recommendations_text' => 'توصیه‌ها',
    'hazard_type' => 'نوع خطر', 'hazard_source' => 'منبع خطر', 'exposed_workers' => 'افراد در معرض',
    'control_status' => 'وضعیت کنترل', 'review_cycle' => 'دوره بازنگری',
    'establishment_name' => 'نام مؤسسه', 'establishment_type' => 'نوع مؤسسه',
    'owner' => 'مالک', 'license_status' => 'وضعیت مجوز', 'last_inspection' => 'آخرین بازرسی',
    'next_inspection' => 'بازرسی بعدی', 'violations' => 'تخلفات', 'penalty' => 'جریمه',
    'permit_no' => 'شماره مجوز', 'permit_type' => 'نوع مجوز', 'issue_date' => 'تاریخ صدور',
    'valid_until' => 'اعتبار تا', 'issuer' => 'صادرکننده',
    'pest_type' => 'نوع آفت', 'method' => 'روش', 'chemical' => 'ماده شیمیایی',
    'area_treated' => 'مساحت سم‌پاشی', 'operator' => 'مجری', 'safety_notes' => 'نکات ایمنی',
    'stat_date' => 'تاریخ آمار', 'attempt_count' => 'تعداد اقدام', 'death_count' => 'تعداد فوت',
    'age_group' => 'گروه سنی', 'method_used' => 'روش', 'location_type' => 'نوع محل',
    'intervention' => 'مداخله', 'is_anonymous' => 'ناشناس',
    'thyroid_result' => 'نتیجه تیروئید', 'tsh' => 'TSH', 't4' => 'T4', 't3' => 'T3',
    'referral_needed' => 'نیاز به ارجاع', 'treatment_started' => 'شروع درمان',
    'stock' => 'موجودی', 'unit_of_measure' => 'واحد اندازه‌گیری', 'storage_condition' => 'شرایط نگهداری',
    'cold_chain' => 'زنجیره سرد', 'distributed_to' => 'توزیع به', 'distributed_by' => 'توزیع‌کننده',
    'received_by' => 'دریافت‌کننده', 'batch' => 'بچ', 'lot_number' => 'شماره لات',
    'organization_unit_id' => 'واحد سازمانی', 'from_unit_id' => 'از واحد', 'to_unit_id' => 'به واحد',
    'transfer_date' => 'تاریخ انتقال', 'transfer_reason' => 'علت انتقال', 'approved' => 'تأیید شده',
    'contract_type' => 'نوع قرارداد', 'salary' => 'حقوق', 'benefits' => 'مزایا',
    'probation_end' => 'پایان آزمایشی', 'termination_date' => 'تاریخ خاتمه',
    'termination_reason' => 'علت خاتمه', 'attendance_date' => 'تاریخ حضور',
    'check_in' => 'ورود', 'check_out' => 'خروج', 'late_minutes' => 'تأخیر (دقیقه)',
    'overtime_minutes' => 'اضافه‌کار (دقیقه)', 'leave_type' => 'نوع مرخصی',
    'days_count' => 'تعداد روز', 'replacement_id' => 'جایگزین', 'evaluation_period' => 'دوره ارزیابی',
    'evaluator_id' => 'ارزیاب', 'overall_score' => 'امتیاز کل', 'strengths' => 'نقاط قوت',
    'weaknesses' => 'نقاط ضعف', 'goals' => 'اهداف', 'retirement_type' => 'نوع بازنشستگی',
    'years_of_service' => 'سنوات', 'decision_date' => 'تاریخ تصمیم', 'decision_status' => 'وضعیت تصمیم',
    'sim_number' => 'شماره سیم', 'operator_name' => 'اپراتور', 'data_plan' => 'طرح اینترنت',
    'assigned_date' => 'تاریخ تخصیص', 'unassigned_date' => 'تاریخ آزادسازی',
    'is_corporate' => 'سازمانی', 'monthly_cost' => 'هزینه ماهانه',
];

function fieldLabel(string $field, array $dict): string
{
    if (isset($dict[$field])) {
        return $dict[$field];
    }
    // humanize
    $label = str_replace(['_id', '_'], ['', ' '], $field);
    $label = trim(preg_replace('/\s+/', ' ', $label) ?? $label);

    return $label;
}

function pluralizeResource(string $short): string
{
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
        'UtilityPaymentLog' => 'UtilityPaymentLogs',
        'UserPermission' => 'UserPermissions',
        'AccessChange' => 'AccessChanges',
        'AccessLevel' => 'AccessLevels',
        'AccessReport' => 'AccessReports',
        'SystemAlert' => 'SystemAlerts',
        'SecurityPolicy' => 'SecurityPolicies',
        'SecurityIncident' => 'SecurityIncidents',
        'UnitAccessRestriction' => 'UnitAccessRestrictions',
        'ManagerAccessLevel' => 'ManagerAccessLevels',
        'ApprovalWorkflow' => 'ApprovalWorkflows',
        'ApprovalRequest' => 'ApprovalRequests',
        'FormTemplate' => 'FormTemplates',
        'FormSubmission' => 'FormSubmissions',
        'TrainingMaterial' => 'TrainingMaterials',
        'TrainingDistribution' => 'TrainingDistributions',
        'TrainingServiceRecord' => 'TrainingServiceRecords',
        'EarlyRetirementCase' => 'EarlyRetirementCases',
        'StaffTransfer' => 'StaffTransfers',
        'PerformanceEvaluation' => 'PerformanceEvaluations',
        'EmployeeContract' => 'EmployeeContracts',
        'AttendanceRecord' => 'AttendanceRecords',
        'LeaveRecord' => 'LeaveRecords',
        'OccupationalExamination' => 'OccupationalExaminations',
        'EnvironmentalEstablishment' => 'EnvironmentalEstablishments',
        'EnvironmentalInspection' => 'EnvironmentalInspections',
        'HealthPermit' => 'HealthPermits',
        'HazardAssessment' => 'HazardAssessments',
        'CompanyInspection' => 'CompanyInspections',
        'ImmunizationRecord' => 'ImmunizationRecords',
        'DentalService' => 'DentalServices',
        'MedicalEquipment' => 'MedicalEquipments',
        'VaccineDrug' => 'VaccineDrugs',
        'VaccineDrugDistribution' => 'VaccineDrugDistributions',
        'FinancialTransaction' => 'FinancialTransactions',
        'OfficialCorrespondence' => 'OfficialCorrespondences',
        'OrganizationalUnit' => 'OrganizationalUnits',
        'CenterBankAccount' => 'CenterBankAccounts',
        'CenterClassification' => 'CenterClassifications',
        'CenterEquipment' => 'CenterEquipments',
        'CenterNetworkConnection' => 'CenterNetworkConnections',
        'CenterPhoneLine' => 'CenterPhoneLines',
        'CenterRelation' => 'CenterRelations',
        'CenterRoom' => 'CenterRooms',
        'CenterType' => 'CenterTypes',
        'CenterUtility' => 'CenterUtilities',
        'FacilityRequest' => 'FacilityRequests',
        'ItRequest' => 'ItRequests',
        'VehicleRequest' => 'VehicleRequests',
        'VehicleTrip' => 'VehicleTrips',
        'FuelRecord' => 'FuelRecords',
        'WorkOrder' => 'WorkOrders',
        'SimCard' => 'SimCards',
        'PregnantWoman' => 'PregnantWomen',
    ];

    if (isset($map[$short])) {
        return $map[$short];
    }
    if (str_ends_with($short, 'y') && ! str_ends_with($short, 'ey')) {
        return substr($short, 0, -1) . 'ies';
    }
    if (preg_match('/(s|x|z|ch|sh)$/', $short)) {
        return $short . 'es';
    }

    return $short . 's';
}

function phpArray(array $arr): string
{
    $parts = [];
    foreach ($arr as $k => $v) {
        $parts[] = var_export((string) $k, true) . ' => ' . var_export((string) $v, true);
    }

    return '[' . implode(', ', $parts) . ']';
}

function optionsFor(string $field): array
{
    $f = strtolower($field);
    if ($f === 'gender' || str_ends_with($f, '_gender') || $f === 'patient_gender') {
        return ['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر', 'unknown' => 'نامشخص'];
    }
    if ($f === 'priority') {
        return ['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'urgent' => 'فوری'];
    }
    if ($f === 'marital_status') {
        return ['single' => 'مجرد', 'married' => 'متأهل', 'divorced' => 'مطلقه', 'widowed' => 'بیوه'];
    }
    if ($f === 'employment_type' || $f === 'contract_type') {
        return [
            'official' => 'رسمی',
            'contract' => 'قراردادی',
            'corporate' => 'شرکتی',
            'conscript' => 'طرحی',
            'temporary' => 'موقت',
            'volunteer' => 'داوطلب',
        ];
    }
    if (str_contains($f, 'status') || $f === 'status' || $f === 'decision' || $f === 'outcome' || $f === 'condition') {
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
            'resolved' => 'حل‌شده',
            'failed' => 'ناموفق',
        ];
    }
    if (str_contains($f, 'type') || $f === 'category' || $f === 'level' || str_contains($f, 'severity') || str_contains($f, 'risk')) {
        return [
            'low' => 'کم',
            'medium' => 'متوسط',
            'high' => 'بالا',
            'critical' => 'بحرانی',
            'general' => 'عمومی',
            'special' => 'تخصصی',
            'other' => 'سایر',
        ];
    }

    return ['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'];
}

function isBoolField(string $field, $cast): bool
{
    if (is_string($cast) && str_contains(strtolower($cast), 'bool')) {
        return true;
    }

    return (bool) preg_match('/^(is_|has_|can_|lab_|contact_|isolation_|budget_|cold_|referral_|treatment_|is)/', $field);
}

function isDateField(string $field, $cast): bool
{
    if (is_string($cast) && (str_contains($cast, 'date') || str_contains($cast, 'datetime') || str_contains($cast, 'immutable'))) {
        return true;
    }

    return (bool) preg_match('/(_date|_at|date$|expiry|scheduled|due_|lmp_|edd_)/', $field);
}

function isDateTimeField(string $field, $cast): bool
{
    if (is_string($cast) && str_contains($cast, 'datetime')) {
        return true;
    }

    return (bool) preg_match('/(_at$|datetime|preferred_time|check_in|check_out|started_at|finished_at)/', $field);
}

function isNumericField(string $field, $cast, ?string $colType): bool
{
    if (is_string($cast) && preg_match('/int|float|double|decimal|real/', $cast)) {
        return true;
    }
    if ($colType && preg_match('/int|decimal|float|double|bigint|smallint|tinyint/', $colType)) {
        return true;
    }

    return (bool) preg_match('/(amount|price|total|quantity|count|score|age|year|month|km|liters|cost|balance|capacity|floors|rooms|population|minutes|hours|weight|height|bmi|tsh|t4|t3|odometer|salary|debit|credit|stock|days_)/', $field)
        || str_ends_with($field, '_id');
}

function isTextArea(string $field, $cast): bool
{
    if (is_string($cast) && preg_match('/array|json|collection|object/', $cast)) {
        return true;
    }

    return (bool) preg_match('/(description|notes|address|content|body|details|reason|comment|findings|recommendations|symptoms|treatment|payload|data|meta|settings|config|checklist|materials|goals|strengths|weaknesses|violations|lessons|root_cause|containment|care_plan|feedback|prescription|diagnosis|risk_factors|policy_body|form_data|old_values|new_values|images)/', $field);
}

function relationLookup(array $relations): array
{
    // foreign_key => related model short
    $map = [];
    foreach ($relations as $name => $rel) {
        if (! in_array($rel['type'], ['BelongsTo'], true)) {
            continue;
        }
        $fk = $rel['foreign_key'] ?? null;
        if (! $fk) {
            continue;
        }
        $map[$fk] = [
            'related' => $rel['related_short'],
            'related_class' => $rel['related'],
            'relation' => $name,
        ];
    }

    return $map;
}

function titleColumnsFor(string $relatedShort): array
{
    // preferred display columns for relationship selects
    $defaults = [
        'Center' => ['name', 'code'],
        'Company' => ['name', 'registration_number'],
        'Employee' => ['first_name', 'last_name', 'personnel_code', 'name'],
        'User' => ['name', 'email'],
        'Role' => ['display_name', 'name'],
        'Permission' => ['display_name', 'name'],
        'Vehicle' => ['plate_number', 'name', 'model'],
        'Driver' => ['name', 'employee_id'],
        'OrganizationalUnit' => ['name', 'code'],
        'FormTemplate' => ['name', 'title'],
        'VaccineDrug' => ['name', 'code'],
        'TrainingMaterial' => ['title', 'name'],
        'PregnantWoman' => ['full_name', 'national_id', 'name'],
        'ApprovalWorkflow' => ['name', 'title'],
    ];

    return $defaults[$relatedShort] ?? ['name', 'title', 'code', 'full_name', 'id'];
}

function writeFile(string $path, string $content): void
{
    $dir = dirname($path);
    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    file_put_contents($path, $content);
}

function sectionForField(string $field): string
{
    if (preg_match('/(_id$|requested_by|approved_by|assigned_to|created_by|updated_by|inspector_id|evaluator_id|supervisor_id|custodian_id|technician_id|submitted_by|reviewed_by|granted_by|reported_by|owner_id|manager_id)/', $field)) {
        return 'ارتباطات';
    }
    if (preg_match('/(status|priority|type|level|category|severity|risk|decision|outcome|condition|is_|has_|can_)/', $field)) {
        return 'وضعیت و نوع';
    }
    if (preg_match('/(date|at$|year|month|time|expiry|scheduled|due_)/', $field)) {
        return 'تاریخ‌ها';
    }
    if (preg_match('/(amount|price|cost|total|salary|balance|debit|credit|quantity|stock|budget)/', $field)) {
        return 'مالی و مقادیر';
    }
    if (preg_match('/(phone|mobile|email|address|city|province|district|postal|gps|location|website|fax)/', $field)) {
        return 'اطلاعات تماس و مکان';
    }
    if (preg_match('/(description|notes|comment|content|body|details|reason|findings|recommendations|symptoms|treatment|goals)/', $field)) {
        return 'توضیحات';
    }

    return 'اطلاعات اصلی';
}

// Index models by short name
$byShort = [];
foreach ($meta as $m) {
    $byShort[$m['short']] = $m;
}

$generated = [];
$resourcesRoot = $root . '/app/Filament/Resources';
$idx = 0;

foreach ($meta as $model) {
    $short = $model['short'];
    if (in_array($short, $skip, true)) {
        continue;
    }

    $idx++;
    $resource = $short . 'Resource';
    $pagesNs = "App\\Filament\\Resources\\{$resource}\\Pages";
    $casts = $model['casts'] ?? [];
    $fillable = $model['fillable'] ?? [];
    $columns = $model['columns'] ?? [];
    $colTypes = $model['column_types'] ?? [];
    $relations = $model['relations'] ?? [];
    $fkMap = relationLookup($relations);

    $fields = $fillable !== [] ? $fillable : $columns;
    $fields = array_values(array_filter($fields, fn ($c) => ! in_array($c, $skipColumns, true)));

    // ensure important FKs included even if not fillable
    foreach (array_keys($fkMap) as $fk) {
        if (! in_array($fk, $fields, true) && in_array($fk, $columns, true) && ! in_array($fk, $skipColumns, true)) {
            $fields[] = $fk;
        }
    }

    [$singular, $plural, $group, $icon] = $labels[$short] ?? [
        $short, $short, 'سایر', 'heroicon-o-rectangle-stack',
    ];
    $navSort = ($groupSort[$group] ?? 50) * 100 + ($idx % 90);

    $pluralClass = pluralizeResource($short);
    $listClass = 'List' . $pluralClass;
    $createClass = 'Create' . $short;
    $editClass = 'Edit' . $short;

    // Build form sections
    $sectionFields = [];
    $maxFields = 40;
    $count = 0;
    foreach ($fields as $field) {
        if ($count >= $maxFields) {
            break;
        }
        // password only on create for User
        if ($field === 'password' && $short !== 'User') {
            continue;
        }
        $section = sectionForField($field);
        $sectionFields[$section][] = $field;
        $count++;
    }
    if ($sectionFields === []) {
        $sectionFields['اطلاعات اصلی'] = ['id'];
    }

    // collect relation model imports
    $imports = [
        "use App\\Filament\\Resources\\{$resource}\\Pages;",
        "use App\\Models\\{$short};",
        'use Filament\\Actions;',
        'use Filament\\Forms;',
        'use Filament\\Resources\\Resource;',
        'use Filament\\Schemas\\Components\\Section;',
        'use Filament\\Schemas\\Schema;',
        'use Filament\\Tables;',
        'use Filament\\Tables\\Table;',
        'use Illuminate\\Database\\Eloquent\\Builder;',
    ];
    $relatedImports = [];
    foreach ($fkMap as $info) {
        $relatedImports[$info['related']] = "use App\\Models\\{$info['related']};";
    }
    $imports = array_merge($imports, array_values($relatedImports));
    sort($imports);
    // keep Pages/Model near top - fine

    $formParts = [];
    foreach ($sectionFields as $sectionName => $sectionFieldList) {
        $fieldLines = [];
        foreach ($sectionFieldList as $field) {
            if ($field === 'id') {
                $fieldLines[] = "                    Forms\\Components\\TextInput::make('id')->label('شناسه')->disabled()->dehydrated(false),";
                continue;
            }

            $label = fieldLabel($field, $fieldLabels);
            $cast = $casts[$field] ?? null;
            $colType = $colTypes[$field] ?? null;

            if ($field === 'password') {
                $fieldLines[] = "                    Forms\\Components\\TextInput::make('password')";
                $fieldLines[] = "                        ->label('{$label}')";
                $fieldLines[] = "                        ->password()";
                $fieldLines[] = "                        ->revealable()";
                $fieldLines[] = "                        ->dehydrated(fn (\$state) => filled(\$state))";
                $fieldLines[] = "                        ->required(fn (string \$operation) => \$operation === 'create')";
                $fieldLines[] = "                        ->maxLength(255),";
                continue;
            }

            if (isset($fkMap[$field])) {
                $rel = $fkMap[$field];
                $related = $rel['related'];
                $titleCols = titleColumnsFor($related);
                // build option label expression
                $labelBits = [];
                foreach ($titleCols as $tc) {
                    $labelBits[] = "(\$record->{$tc} ?? null)";
                }
                $labelExpr = implode(' ?: ', $labelBits) . " ?: ('#' . \$record->getKey())";

                $fieldLines[] = "                    Forms\\Components\\Select::make('{$field}')";
                $fieldLines[] = "                        ->label('{$label}')";
                $fieldLines[] = "                        ->relationship(name: '{$rel['relation']}', titleAttribute: 'id')";
                $fieldLines[] = "                        ->getOptionLabelFromRecordUsing(fn (\\App\\Models\\{$related} \$record) => (string) ({$labelExpr}))";
                $fieldLines[] = "                        ->searchable()";
                $fieldLines[] = "                        ->preload()";
                $fieldLines[] = "                        ->native(false)";
                // required if column likely not nullable unknown - keep optional except center_id on core models
                if (in_array($field, ['center_id'], true) && in_array($short, ['Employee', 'Inspection', 'FacilityRequest', 'ItRequest', 'VehicleRequest', 'PregnantWoman', 'DiseaseSurveillance'], true)) {
                    $fieldLines[] = '                        ->required(),';
                } else {
                    $fieldLines[] = '                        ->nullable(),';
                }
                continue;
            }

            if (isBoolField($field, $cast)) {
                $fieldLines[] = "                    Forms\\Components\\Toggle::make('{$field}')";
                $fieldLines[] = "                        ->label('{$label}')";
                $fieldLines[] = "                        ->default(false),";
                continue;
            }

            if (isDateTimeField($field, $cast)) {
                $fieldLines[] = "                    Forms\\Components\\DateTimePicker::make('{$field}')";
                $fieldLines[] = "                        ->label('{$label}')";
                $fieldLines[] = "                        ->native(false)";
                $fieldLines[] = "                        ->seconds(false),";
                continue;
            }

            if (isDateField($field, $cast)) {
                $fieldLines[] = "                    Forms\\Components\\DatePicker::make('{$field}')";
                $fieldLines[] = "                        ->label('{$label}')";
                $fieldLines[] = "                        ->native(false),";
                continue;
            }

            if (isTextArea($field, $cast)) {
                $fieldLines[] = "                    Forms\\Components\\Textarea::make('{$field}')";
                $fieldLines[] = "                        ->label('{$label}')";
                $fieldLines[] = "                        ->rows(3)";
                $fieldLines[] = "                        ->columnSpanFull(),";
                continue;
            }

            // selects for enum-ish
            if (preg_match('/(status|priority|type|gender|level|category|severity|risk|decision|outcome|condition|employment_type|contract_type|marital_status|facility_type|leave_type|fuel_type|inspection_type)$/', $field)
                || str_ends_with($field, '_status') || str_ends_with($field, '_type') || str_ends_with($field, '_level')) {
                $opts = optionsFor($field);
                $fieldLines[] = "                    Forms\\Components\\Select::make('{$field}')";
                $fieldLines[] = "                        ->label('{$label}')";
                $fieldLines[] = '                        ->options(' . phpArray($opts) . ')';
                $fieldLines[] = "                        ->searchable()";
                $fieldLines[] = "                        ->native(false)";
                $fieldLines[] = "                        ->nullable(),";
                continue;
            }

            $fieldLines[] = "                    Forms\\Components\\TextInput::make('{$field}')";
            $fieldLines[] = "                        ->label('{$label}')";
            if ($field === 'email' || str_ends_with($field, '_email')) {
                $fieldLines[] = '                        ->email()';
            }
            if (preg_match('/phone|mobile|fax|tel/', $field)) {
                $fieldLines[] = '                        ->tel()';
            }
            if (isNumericField($field, $cast, $colType) && ! str_ends_with($field, '_id')) {
                $fieldLines[] = '                        ->numeric()';
            }
            if (in_array($field, ['name', 'title', 'code', 'full_name', 'first_name', 'last_name'], true)) {
                $fieldLines[] = '                        ->required()';
            }
            $fieldLines[] = '                        ->maxLength(255),';
        }

        $fieldsBlock = implode("\n", $fieldLines);
        $formParts[] = <<<PHP
            Section::make('{$sectionName}')
                ->schema([
{$fieldsBlock}
                ])
                ->columns(2)
                ->collapsible(),
PHP;
    }

    $formSchema = implode("\n", $formParts);

    // Table columns
    $prefer = [];
    foreach (['name', 'title', 'code', 'full_name', 'first_name', 'last_name', 'status', 'type', 'priority', 'phone', 'city', 'center_id', 'employee_id', 'company_id', 'date', 'request_date', 'inspection_date', 'amount', 'is_active', 'email'] as $p) {
        if (in_array($p, $fields, true)) {
            $prefer[] = $p;
        }
    }
    foreach ($fields as $f) {
        if (! in_array($f, $prefer, true)) {
            $prefer[] = $f;
        }
        if (count($prefer) >= 9) {
            break;
        }
    }

    $tableLines = [];
    $filterLines = [];
    foreach (array_slice($prefer, 0, 9) as $i => $field) {
        $label = fieldLabel($field, $fieldLabels);
        $cast = $casts[$field] ?? null;

        if (isset($fkMap[$field])) {
            $rel = $fkMap[$field];
            $related = $rel['related'];
            $titleCols = titleColumnsFor($related);
            $attr = $titleCols[0] ?? 'id';
            // relationship column
            $tableLines[] = "                Tables\\Columns\\TextColumn::make('{$rel['relation']}.{$attr}')";
            $tableLines[] = "                    ->label('{$label}')";
            $tableLines[] = '                    ->searchable()';
            $tableLines[] = '                    ->sortable()';
            $tableLines[] = '                    ->toggleable(),';

            $filterLines[] = "                Tables\\Filters\\SelectFilter::make('{$field}')";
            $filterLines[] = "                    ->label('{$label}')";
            $filterLines[] = "                    ->relationship('{$rel['relation']}', 'id')";
            $filterLines[] = "                    ->getOptionLabelFromRecordUsing(fn (\\App\\Models\\{$related} \$record) => (string) ((" . implode(' ?: ', array_map(fn ($c) => "(\$record->{$c} ?? null)", $titleCols)) . ") ?: ('#' . \$record->getKey())))";
            $filterLines[] = '                    ->searchable()';
            $filterLines[] = '                    ->preload(),';
            continue;
        }

        if (isBoolField($field, $cast)) {
            $tableLines[] = "                Tables\\Columns\\IconColumn::make('{$field}')";
            $tableLines[] = "                    ->label('{$label}')";
            $tableLines[] = '                    ->boolean()';
            $tableLines[] = '                    ->toggleable(),';
            $filterLines[] = "                Tables\\Filters\\TernaryFilter::make('{$field}')->label('{$label}'),";
            continue;
        }

        $tableLines[] = "                Tables\\Columns\\TextColumn::make('{$field}')";
        $tableLines[] = "                    ->label('{$label}')";
        if ($i < 3) {
            $tableLines[] = '                    ->searchable()';
            $tableLines[] = '                    ->sortable()';
        }
        if (isDateField($field, $cast)) {
            $tableLines[] = '                    ->date()';
            $tableLines[] = '                    ->sortable()';
        }
        if ($field === 'status' || str_ends_with($field, '_status') || $field === 'priority') {
            $tableLines[] = '                    ->badge()';
            $filterLines[] = "                Tables\\Filters\\SelectFilter::make('{$field}')";
            $filterLines[] = "                    ->label('{$label}')";
            $filterLines[] = '                    ->options(' . phpArray(optionsFor($field)) . '),';
        }
        if (isNumericField($field, $cast, $colTypes[$field] ?? null) && ! isDateField($field, $cast)) {
            // keep default
        }
        $tableLines[] = '                    ->toggleable(),';
    }

    if ($tableLines === []) {
        $tableLines[] = "                Tables\\Columns\\TextColumn::make('id')->label('شناسه')->sortable(),";
    }

    // always add created_at if exists
    if (in_array('created_at', $columns, true)) {
        $tableLines[] = "                Tables\\Columns\\TextColumn::make('created_at')";
        $tableLines[] = "                    ->label('ایجاد')";
        $tableLines[] = '                    ->dateTime()';
        $tableLines[] = '                    ->since()';
        $tableLines[] = '                    ->sortable()';
        $tableLines[] = '                    ->toggleable(isToggledHiddenByDefault: true),';
    }

    $tableBlock = implode("\n", $tableLines);
    $filtersBlock = $filterLines !== [] ? implode("\n", $filterLines) : '';

    $filtersSection = $filtersBlock !== ''
        ? "            ->filters([\n{$filtersBlock}\n            ])"
        : '            ->filters([])';

    $importBlock = implode("\n", array_unique($imports));

    $resourcePhp = <<<PHP
<?php

namespace App\Filament\Resources;

{$importBlock}

class {$resource} extends Resource
{
    protected static ?string \$model = {$short}::class;

    protected static ?string \$modelLabel = '{$singular}';

    protected static ?string \$pluralModelLabel = '{$plural}';

    protected static ?string \$navigationLabel = '{$plural}';

    protected static string|\\UnitEnum|null \$navigationGroup = '{$group}';

    protected static string|\\BackedEnum|null \$navigationIcon = '{$icon}';

    protected static ?int \$navigationSort = {$navSort};

    public static function form(Schema \$schema): Schema
    {
        return \$schema->schema([
{$formSchema}
        ]);
    }

    public static function table(Table \$table): Table
    {
        return \$table
            ->columns([
{$tableBlock}
            ])
{$filtersSection}
            ->actions([
                Actions\\EditAction::make(),
                Actions\\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\\BulkActionGroup::make([
                    Actions\\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort(static::getModel()::CREATED_AT ? 'created_at' : 'id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\\{$listClass}::route('/'),
            'create' => Pages\\{$createClass}::route('/create'),
            'edit' => Pages\\{$editClass}::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}

PHP;

    // Fix defaultSort broken ternary - CREATED_AT constant may not exist. Simpler:
    $resourcePhp = str_replace(
        "->defaultSort(static::getModel()::CREATED_AT ? 'created_at' : 'id', 'desc');",
        "->defaultSort('id', 'desc');",
        $resourcePhp
    );

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

    $generated[] = $short;
}

// Provider with discoverResources
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
            ->sidebarWidth('18rem')
            ->collapsedSidebarWidth('4.5rem')
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

// Dashboard widgets enhancement - keep existing

echo 'Generated ' . count($generated) . " upgraded resources\n";
file_put_contents($root . '/storage/app/generated_resources_v2.json', json_encode([
    'count' => count($generated),
    'resources' => $generated,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
