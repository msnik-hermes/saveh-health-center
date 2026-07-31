# Comprehensive Report: Iranian Health Center Management System
## سیستم مدیریت مراکز بهداشتی ایران
### For: Saveh, Markazi Province, Iran
### Date: July 2026

---

## TABLE OF CONTENTS
1. [National Health System Architecture](#1-national-health-system-architecture)
2. [Health Center Types & Hierarchy](#2-health-center-types--hierarchy)
3. [Organizational Units & Responsibilities](#3-organizational-units--responsibilities)
4. [Employee Types & Contract Types](#4-employee-types--contract-types)
5. [Health Service Delivery System](#5-health-service-delivery-system)
6. [Data Fields for Each Unit](#6-data-fields-for-each-unit)
7. [Standard Forms & Workflows](#7-standard-forms--workflows)
8. [Existing Health Management Software](#8-existing-health-management-software)
9. [Entity Relationship Diagram](#9-entity-relationship-diagram)
10. [Saveh-Specific Considerations](#10-saveh-specific-considerations)

---

## 1. NATIONAL HEALTH SYSTEM ARCHITECTURE

### 1.1 Government Hierarchy

```
وزارت بهداشت، درمان و آموزش پزشکی
Ministry of Health, Treatment and Medical Education (MOHME)
│
├── معاونت بهداشتی
│   Deputy of Health
│   │
│   ├── مرکز مدیریت بیماری‌های واگیردار
│   │   Center for Communicable Disease Control
│   │
│   ├── مرکز مدیریت بیماری‌های غیرواگیر
│   │   Center for Non-Communicable Disease Control
│   │
│   ├── مرکز سلامت خانواده، جمعیت و مدارس
│   │   Center for Family Health, Population and Schools
│   │
│   ├── مرکز بهداشت محیط و حرفه‌ای
│   │   Center for Environmental and Occupational Health
│   │
│   ├── مرکز تغذیه
│   │   Center for Nutrition
│   │
│   └── مرکز سلامت روان و اجتماعی
│       Center for Mental and Social Health
│
├── معاونت درمانی
│   Deputy of Treatment
│
├── معاونت آموزشی
│   Deputy of Education
│
└── معاونت پژوهشی
    Deputy of Research
```

### 1.2 Provincial Level Structure (Markazi Province)

```
دانشگاه علوم پزشکی و خدمات بهداشتی درمانی استان مرکزی
University of Medical Sciences and Health Services - Markazi Province
│
├── معاونت بهداشتی (Deputy of Health)
│   ├── مرکز مدیریت شبکه (Network Management Center)
│   ├── گروه سلامت خانواده (Family Health Group)
│   ├── گروه بیماری‌ها (Diseases Group)
│   ├── گروه بهداشت محیط (Environmental Health Group)
│   ├── گروه تغذیه (Nutrition Group)
│   ├── گروه سلامت روان (Mental Health Group)
│   └── واحد فناوری اطلاعات سلامت (Health IT Unit)
│
├── معاونت درمانی
└── معاونت آموزشی
```

### 1.3 County Level (شهرستان) - Saveh

```
مرکز بهداشت شهرستان ساوه
Saveh County Health Center
│
├── مدیر مرکز (Center Director)
├── معاون فنی (Technical Deputy)
├── معاون اداری و مالی (Administrative & Financial Deputy)
└── واحدهای تخصصی (Specialized Units)
```

---

## 2. HEALTH CENTER TYPES & HIERARCHY

### 2.1 مرکز بهداشت شهرستان (County Health Center)

**Persian Name:** مرکز بهداشت شهرستان
**English:** County Health Center
**Code:** MC-001
**Population Served:** 50,000 - 500,000+ (varies by county)

**Description:** The primary administrative and technical center responsible for coordinating all health services within a county (شهرستان). It serves as the hub connecting the university to all lower-level facilities.

**Core Functions:**
- Policy implementation and supervision of all health networks
- Data aggregation and reporting to provincial level
- Training and capacity building for lower-level staff
- Quality assurance and monitoring
- Coordination between health networks
- Management of referral system
- Emergency preparedness and response

**Facilities:**
- Administrative offices
- Training center/meeting rooms
- Laboratory (basic)
- Drug warehouse
- Transport fleet
- IT infrastructure
- Emergency operations center

### 2.2 مرکز جامع سلامت (Comprehensive Health Center)

**Persian Name:** مرکز جامع سلامت شهر/روستا
**English:** Comprehensive Health Center (Urban/Rural)
**Code:** MC-002
**Population Served:** 20,000 - 50,000
**Replaces:** Previous "مرکز بهداشتی-درمانی" centers

**Description:** The upgraded service delivery point combining preventive and curative services. This is the backbone of the Iranian health network system, operating at the city or rural network level.

**Core Functions:**
- Primary healthcare delivery
- Referral to higher levels
- Community health education
- Disease surveillance
- Maternal and child health services
- School health services
- Environmental health monitoring
- Nutrition counseling

**Facilities:**
- Outpatient clinics (GP, specialist referral)
- Maternal health unit
- Child health unit
- Dental unit (basic)
- Laboratory
- Pharmacy/drugstore
- Vaccination center
- Health education room
- Sanitary inspection office
- Environmental health lab

### 2.3 خانه بهداشت (Health House)

**Persian Name:** خانه بهداشت
**English:** Health House
**Code:** MC-003
**Population Served:** 1,500 - 3,000 (rural catchment)
**Supervising Unit:** Comprehensive Health Center (Rural)

**Description:** The foundational unit of the Iranian PHC system (one of the most recognized PHC models globally). Operated by a بهورز (Behvarz - Community Health Worker) with a high school diploma + 2-year health training.

**Core Functions:**
- Basic health services for rural population
- Maternal health monitoring
- Child growth monitoring
- Vaccination (EPI)
- First aid and basic treatment
- Health education and promotion
- Environmental health inspection
- Disease surveillance and reporting
- Household registration and follow-up
- Referral to health center

**Facilities:**
- Single room clinic (converted from housing typically)
- Basic drug supply
- Vaccination refrigerator
- Health records
- First aid equipment
- Basic laboratory supplies

### 2.4 پایگاه سلامت (Health Base / Health Post)

**Persian Name:** پایگاه سلامت
**English:** Health Base / Health Post
**Code:** MC-004
**Population Served:** 5,000 - 10,000 (urban catchment)
**Supervising Unit:** Comprehensive Health Center (Urban)

**Description:** Urban equivalent of health houses, serving urban neighborhoods. Staffed by health workers (بهداشتکار) rather than بهورز.

**Core Functions:**
- Urban primary health services
- Maternal health visits
- Child health monitoring
- Vaccination
- Health education
- Disease screening
- Chronic disease monitoring
- Environmental health basics

**Facilities:**
- Clinical room
- Vaccination area
- Health records storage
- Basic equipment
- Health education materials

### 2.5 پلی‌کلینیک تخصصی (Specialist Polyclinic)

**Persian Name:** پلی‌کلینیک تخصصی
**English:** Specialist Polyclinic
**Code:** MC-005
**Population Served:** City-level
**Supervising Unit:** County Health Center / Hospital

**Description:** Specialist outpatient clinics attached to hospitals or county health centers for secondary care.

### 2.6 لابراتوار مرکزی (Central Laboratory)

**Persian Name:** لابراتوار مرکزی
**English:** Central Laboratory
**Code:** MC-006
**Supervising Unit:** County Health Center

**Description:** Centralized laboratory facility serving the county with diagnostic services.

---

## 3. ORGANIZATIONAL UNITS & RESPONSIBILITIES

### 3.1 Complete Unit Structure for County Health Center (مرکز بهداشت شهرستان)

#### Unit 1: معاونت فنی و بهداشتی (Technical & Health Deputy)
**Unit Code:** U-001

**Responsibilities:**
- Overall coordination of all health programs
- Quality assurance
- Performance monitoring
- Staff technical supervision
- Program evaluation
- Report compilation
- Liaison with university

**Data Fields:**
- deputy_id, center_id, deputy_name, deputy_staff_no
- evaluation_reports[], program_plans[], quality_metrics[]
- performance_indicators[], supervision_visits[]

---

#### Unit 2: سلامت خانواده، جمعیت و مدارس (Family Health, Population & Schools)
**Unit Code:** U-002

**Sub-units:**
- U-002A: سلامت مادران (Maternal Health)
- U-002B: سلامت کودکان (Child Health)
- U-002C: جمعیت و تنظیم خانواده (Population & Family Planning)
- U-002D: بهداشت مدارس (School Health)

**Responsibilities:**
- Prenatal care coordination
- Safe delivery monitoring
- Postnatal care follow-up
- Child growth monitoring (weight, height, head circumference)
- Immunization program management
- Family planning services
- School health inspections
- Student health records
- Adolescent health programs
- Pre-marriage counseling

**Standard Services/Indicators:**
- Percentage of deliveries attended by skilled birth attendant
- Percentage of children fully vaccinated
- Percentage of pregnant women with 8+ prenatal visits
- Contraceptive prevalence rate
- Student BMI monitoring
- School health inspections completed

**Data Fields:**
- visit_id, patient_id, center_id, date
- maternal fields: pregnant_woman_id, gestational_age, prenatal_visit_count, risk_level, delivery_type, delivery_location, postnatal_visits, complications
- child fields: child_id, date_of_birth, weight_percentile, height_percentile, head_circumference, vaccination_status, growth_chart_data[]
- family_planning: client_id, method_type, start_date, end_date, side_effects, follow_up_date
- school: school_name, student_id, grade, health_screening_type, result, bmi, vision_test, hearing_test, dental_check

---

#### Unit 3: مدیریت بیماری‌ها (Disease Management)
**Unit Code:** U-003

**Sub-units:**
- U-003A: بیماری‌های واگیردار (Communicable Diseases)
- U-003B: بیماری‌های غیرواگیر (Non-Communicable Diseases - NCD)
- U-003C: بیماری‌های مشترک انسان و دام (Zoonotic Diseases)

**Responsibilities:**
- Disease surveillance and early warning
- Outbreak investigation and response
- NCD screening programs (diabetes, hypertension, cancer)
- TB control program
- Malaria control (seasonal)
- STI/HIV monitoring
- Vaccination program monitoring
- Vector control
- Contact tracing
- Case management
- Reporting to CDC

**NCD Sub-programs:**
- دیابت (Diabetes) - screening, management, follow-up
- فشار خون (Hypertension) - screening, management
- سرطان (Cancer) - screening (breast, cervical, colorectal)
- بیماری‌های قلبی عروقی (CVD) - risk assessment
- بیماری‌های کلیوی (Chronic Kidney Disease)
- بیماری‌های تنفسی مزمن (COPD/Asthma)

**Data Fields:**
- case_id, patient_id, disease_code (ICD-10), center_id, date_reported
- communicable: disease_type, onset_date, symptoms[], lab_result, confirmation_status, source_of_infection, contacts_traced, treatment_outcome
- ncd: screening_type, screening_date, result, risk_factors[], lab_values (HbA1c, BP, cholesterol), diagnosis_date, treatment_plan, compliance_rate, last_checkup_date
- surveillance: reporting_period, facility_id, total_cases, new_cases, deaths, notifications_sent

---

#### Unit 4: بهداشت محیط (Environmental Health)
**Unit Code:** U-004

**Responsibilities:**
- Water quality monitoring
- Food safety inspections
- Air pollution monitoring
- Waste management oversight
- Sanitary permits for food establishments
- Swimming pool water testing
- Industrial waste monitoring
- Environmental health assessments
- Public health hazard response

**Sub-areas:**
- سلامت آب (Water Health)
- سلامت مواد غذایی (Food Safety)
- بهداشت عمومی و حرفه‌ای (Public & Occupational Hygiene)
- مدیریت پسماند (Waste Management)
- بهداشت خاک و فاضلاب (Soil & Sewage Health)

**Data Fields:**
- inspection_id, facility_id, inspector_id, date, facility_type
- water: water_source_type, chlorination_level, turbidity, pH, coliform_count, test_date, compliance_status
- food: establishment_name, license_number, food_type, temperature_compliance, hygiene_score, violations[], corrective_actions[]
- environment: waste_type, disposal_method, air_quality_index, noise_level, soil_contamination_status
- permit: permit_id, permit_type, issue_date, expiry_date, conditions[], renewal_status

---

#### Unit 5: تغذیه (Nutrition)
**Unit Code:** U-005

**Responsibilities:**
- Nutritional status assessment (community level)
- Management of malnutrition cases (SAM/MAM)
- Iron supplementation program
- Breastfeeding promotion (Baby-Friendly Hospital Initiative)
- School nutrition programs
- Nutrition education
- Food fortification monitoring
- Growth monitoring coordination with family health
- Micronutrient supplementation (Vitamin A, Zinc)
- Nutritional surveys

**Data Fields:**
- assessment_id, patient_id, center_id, date
- nutritional: weight, height, BMI, mid_upper_arm_circumference, MUAC_status
- malnutrition: malnutrition_type (SAM/MAM/overweight/obese), treatment_protocol, therapeutic_food_type, supplementation_given
- micronutrient: supplement_type, dosage, start_date, end_date, compliance
- breastfeeding: exclusive_breastfeeding_duration, complementary_feeding_age, breastfeeding_support_given
- community: survey_type, sample_size, prevalence_rates[], target_population

---

#### Unit 6: سلامت روان و اجتماعی (Mental & Social Health)
**Unit Code:** U-006

**Responsibilities:**
- Mental health screening (PHQ-9, GAD-7)
- Substance abuse prevention
- Suicide prevention program
- Elderly mental health
- Child behavioral disorders screening
- Psychosocial support
- Social determinants of health assessment
- Addiction treatment coordination
- Domestic violence intervention
- Community resilience programs

**Data Fields:**
- assessment_id, patient_id, center_id, date, assessor_id
- screening: screening_tool_used, score, risk_level, referral_needed
- mental_health: diagnosis, symptoms[], severity, treatment_plan, medication, therapy_type, follow_up_date
- substance: substance_type, usage_duration, addiction_level, treatment_stage, relapse_history
- social: living_situation, support_system, economic_status, violence_history, social_determinants[]

---

#### Unit 7: بهداشت حرفه‌ای و سلامت شغلی (Occupational Health)
**Unit Code:** U-007

**Responsibilities:**
- Workplace health inspections
- Occupational disease monitoring
- Worker health assessments
- Ergonomic evaluations
- Hazardous material monitoring
- Worker health insurance coordination
- Pre-employment medical examinations
- Noise and chemical exposure monitoring
- Occupational injury reporting
- Return-to-work assessments

**Data Fields:**
- assessment_id, worker_id, workplace_id, date
- workplace: industry_type, worker_count, hazard_categories[], safety_score, inspection_date
- worker: occupation, exposure_type, exposure_level, health_history, pre_employment_exam_date
- occupational_disease: disease_type, work_relatedness_score, onset_date, treatment, disability_level
- injury: injury_type, cause, severity, lost_work_days, reported_to_authorities

---

#### Unit 8: بهداشت مدارس (School Health)
**Unit Code:** U-008

**Responsibilities:**
- Student health records management
- School health inspections
- Vision and hearing screening
- Dental health programs
- Growth monitoring in schools
- Health education in schools
- Infectious disease control in schools
- Mental health awareness programs
- Physical fitness assessments
- Environmental safety of schools

**Data Fields:**
- inspection_id, school_id, student_id, date
- school: school_type, student_count, facilities_score, drinking_water_status, sanitation_facilities
- student: student_id, name, grade, health_screening_date, vision_result, hearing_result, dental_score, bmi, vaccination_status
- interventions: intervention_type, date, description, outcome, follow_up_required

---

#### Unit 9: مدیریت اطلاعات و فناوری (IT & Health Informatics)
**Unit Code:** U-009

**Responsibilities:**
- SIB system management and maintenance
- Data entry supervision
- Report generation
- IT infrastructure maintenance
- Network connectivity
- Data quality assurance
- Staff IT training
- Backup management
- Software deployment
- Integration with higher-level systems

**Data Fields:**
- system_id, center_id, unit_id
- infrastructure: server_status, network_uptime, backup_status, last_backup_date
- data_quality: total_records, error_rate, completeness_rate, timeliness_score
- users: user_id, access_level, last_login, training_status
- software: module_name, version, installation_date, last_update, issues[]

---

#### Unit 10: آمار و ثبت احوال (Statistics & Registration)
**Unit Code:** U-010

**Responsibilities:**
- Population data management
- Vital statistics (birth, death, marriage, divorce)
- Demographic analysis
- Health indicators calculation
- Census coordination
- Geographic Information System (GIS) management
- Catchment area mapping
- Service coverage calculations
- Statistical reports for university/MOHME

**Data Fields:**
- record_type, center_id, date, period
- vital_statistics: births, deaths (neonatal, infant, maternal, total), marriages, divorces, cause_of_death
- population: total_population, male, female, age_groups[], rural_pct, urban_pct
- demographic: migration_in, migration_out, fertility_rate, mortality_rate, growth_rate
- coverage: target_population, served_population, coverage_percentage, gap_analysis[]

---

#### Unit 11: مدیریت و اداری-مالی (Administration & Finance)
**Unit Code:** U-011

**Responsibilities:**
- Human resources management
- Financial management (budgeting, accounting)
- Procurement and supply chain
- Facility management
- Fleet management
- Asset management
- Insurance coordination
- Legal affairs
- Administrative correspondence
- Meeting management
- Document archiving

**Data Fields:**
- hr: employee_id, name, national_code, position, department, contract_type, hire_date, salary_grade, leave_balance, performance_score
- financial: budget_code, fiscal_year, allocated_amount, spent_amount, remaining, cost_center
- procurement: purchase_order_id, item_description, quantity, unit_price, total_cost, supplier, delivery_date, status
- assets: asset_id, asset_type, location, purchase_date, value, condition, maintenance_schedule
- fleet: vehicle_id, vehicle_type, plate_number, mileage, maintenance_date, fuel_log[]

---

#### Unit 12: بهداشت عمومی و پیشگیری (General Health & Prevention)
**Unit Code:** U-012

**Responsibilities:**
- Health promotion campaigns
- Community health education
- Smoking cessation programs
- Physical activity promotion
- Healthy lifestyle programs
- Health literacy improvement
- Community mobilization
- Traditional and complementary medicine coordination
- Health day observances
- Media and communication

**Data Fields:**
- campaign_id, center_id, start_date, end_date
- campaign: campaign_name, target_group, budget, activities[], media_channels[]
- education: topic, venue, attendees_count, satisfaction_score, behavior_change_indicators[]
- community: active_village_committees, community_health_workers, peer_educators_count

---

## 4. EMPLOYEE TYPES & CONTRACT TYPES

### 4.1 Health Personnel Categories

#### Medical Staff (کادر پزشکی)
| Code | Persian Title | English Title | Minimum Education |
|------|--------------|---------------|-------------------|
| MS-01 | پزشک خانواده | Family Physician | MD (General Practitioner) |
| MS-02 | متخصص | Specialist | MD + Residency |
| MS-03 | دندانپزشک | Dentist | DDS |
| MS-04 | داروساز | Pharmacist | PharmD |
| MS-05 | بینایی‌سنج | Optometrist | Bachelor's in Optometry |

#### Nursing Staff (کادر پرستاری)
| Code | Persian Title | English Title | Minimum Education |
|------|--------------|---------------|-------------------|
| NS-01 | ماما | Midwife | BSc Midwifery |
| NS-02 | پرستار | Nurse | BSc Nursing |
| NS-03 | بهیار | Nursing Assistant | Diploma in Nursing |
| NS-04 | کمک بهیار | Aid Nurse | Certificate level |

#### Health Staff (کادر بهداشتی)
| Code | Persian Title | English Title | Minimum Education |
|------|--------------|---------------|-------------------|
| HS-01 | بهورز | Community Health Worker (Behvarz) | High School + 2yr Health Training |
| HS-02 | بهداشتکار محیط | Environmental Health Worker | Associate/BSc Environmental Health |
| HS-03 | بهداشتکار حرفه‌ای | Occupational Health Worker | BSc Occupational Health |
| HS-04 | بهداشتکار مدارس | School Health Worker | BSc Health Education |
| HS-05 | کارشناس تغذیه | Nutritionist | BSc Nutrition |
| HS-06 | کارشناس سلامت روان | Mental Health Worker | BSc Psychology/Public Health |
| HS-07 | کارشناس مبارزه با بیماری‌ها | Disease Control Specialist | BSc Epidemiology/Public Health |
| HS-08 | مامای خانه بهداشت | Health House Midwife | BSc/Diploma Midwifery |

#### Administrative & Support Staff (کادر اداری و پشتیبانی)
| Code | Persian Title | English Title | Minimum Education |
|------|--------------|---------------|-------------------|
| AS-01 | رئیس اداری | Administrative Head | Bachelor's |
| AS-02 | کارشناس مالی | Financial Officer | Bachelor's in Accounting |
| AS-03 | کارشناس فناوری اطلاعات | IT Specialist | Bachelor's in CS/IT |
| AS-04 | کارشناس آمار | Statistician | Bachelor's in Statistics |
| AS-05 | منشی | Secretary | Diploma+ |
| AS-06 | راننده | Driver | High School + License |
| AS-07 | نگهبان | Security Guard | High School |
| AS-08 | نظافتچی | Cleaner | - |
| AS-09 | تکنسین آزمایشگاه | Lab Technician | Associate/BSc Lab Sciences |
| AS-10 | تکنسین داروخانه | Pharmacy Technician | Associate in Pharmacy |

### 4.2 Contract Types (نوع قرارداد)

#### 1. استخدام رسمی (Permanent/Civil Service Employment)
- **Code:** CT-001
- **Description:** Government permanent employees through سازمان اداری و استخدامی کشور
- **Benefits:** Full government benefits, pension (صندوق بازنشستگی), housing allowance, transportation allowance, insurance
- **Duration:** Indefinite (until retirement)
- **Salary Scale:** Based on government pay grades (سازمان برنامه و بودجه)
- **Typical Staff:** Senior administrators, some permanent physicians

#### 2. استخدام پیمانی (Contract Employment)
- **Code:** CT-002
- **Description:** Contract-based employees with specific terms
- **Benefits:** Partial government benefits, pension, insurance
- **Duration:** Usually 1-3 years, renewable
- **Salary Scale:** Government contract rates
- **Typical Staff:** Nurses, midwives, health workers

#### 3. قرارداد کار معین (Specific Work Contract / Task-Based)
- **Code:** CT-003
- **Description:** Contract for specific work duration or project
- **Benefits:** Minimal - mainly insurance
- **Duration:** Usually 6 months to 1 year
- **Typical Staff:** Temporary health workers, project-based hires

#### 4. قرارداد مشاوره (Consulting Contract)
- **Code:** CT-004
- **Description:** Specialist consulting arrangements
- **Benefits:** Per-consultation fee
- **Duration:** Per session/project
- **Typical Staff:** Specialist physicians for limited clinic hours

#### 5. حق التدریس / حق العمل (Teaching/Labour Rights)
- **Code:** CT-005
- **Description:** Payment-based contracts for part-time work
- **Benefits:** None beyond payment
- **Duration:** Per semester/project
- **Typical Staff:** University-affiliated staff providing part-time services

#### 6. طرح (Obligatory Service - طرح نیروی انسانی)
- **Code:** CT-006
- **Description:** Mandatory government service obligation after graduation (similar to residency/service programs in other countries)
- **Duration:** Typically 1-2 years (medicine), varies by profession
- **Benefits:** Basic salary + rural allowance
- **Typical Staff:** Newly graduated physicians, dentists, pharmacists, nurses
- **Special Note:** Often deployed to underserved/rural areas; Saveh may receive طرح staff

#### 7. بسیج جامعه پزشکی (Medical Mobilization Corps)
- **Code:** CT-007
- **Description:** Medical professionals serving in underserved areas through Bassij organization
- **Duration:** Usually 1 year
- **Benefits:** Government salary + special allowances

#### 8. قرارداد شرکتی / پیمانکاری (Outsourced/Company Contract)
- **Code:** CT-008
- **Description:** Staff hired through third-party companies
- **Benefits:** Company-provided (usually minimal)
- **Duration:** Per company contract
- **Typical Staff:** Support staff (cleaning, security, drivers)

### 4.3 Employee Data Fields

```sql
-- Employee Master Table
CREATE TABLE employees (
    employee_id         SERIAL PRIMARY KEY,
    national_code       VARCHAR(10) UNIQUE NOT NULL,  -- کد ملی
    first_name_fa       VARCHAR(50) NOT NULL,          -- نام
    last_name_fa        VARCHAR(50) NOT NULL,          -- نام خانوادگی
    father_name         VARCHAR(50),                   -- نام پدر
    birth_date          DATE,                          -- تاریخ تولد
    birth_certificate_no VARCHAR(20),                  -- شماره شناسنامه
    gender              VARCHAR(10),                   -- جنسیت
    marital_status      VARCHAR(20),                   -- وضعیت تاهل
    national_id_no      VARCHAR(10),                   -- شماره ملی
    military_service_status VARCHAR(20),               -- وضعیت خدمت سربازی
    
    -- Contact
    mobile_number       VARCHAR(15),
    phone_number        VARCHAR(15),
    address             TEXT,
    city                VARCHAR(50),
    province            VARCHAR(50),
    
    -- Employment
    employee_code       VARCHAR(20),                   -- شماره پرسنلی
    center_id           INTEGER REFERENCES health_centers(center_id),
    position_code       VARCHAR(20),                   -- کد پست سازمانی
    position_title_fa   VARCHAR(100),                  -- عنوان پست
    department_code     VARCHAR(20),                   -- کد واحد سازمانی
    contract_type       VARCHAR(20),                   -- نوع قرارداد
    employment_date     DATE,                          -- تاریخ استخدام
    contract_start      DATE,                          -- شروع قرارداد
    contract_end        DATE,                          -- پایان قرارداد
    salary_grade        INTEGER,                       -- گروه و رتبه
    
    -- Education
    education_level     VARCHAR(50),                   -- مقطع تحصیلی
    field_of_study      VARCHAR(100),                  -- رشته تحصیلی
    university          VARCHAR(100),                  -- دانشگاه فارغ‌التحصیلی
    graduation_year     INTEGER,                       -- سال فارغ‌التحصیلی
    medical_license_no  VARCHAR(20),                   -- شماره پروانه
    
    -- Status
    employment_status   VARCHAR(20) DEFAULT 'active',  -- active/leave/terminated/suspended
    insurance_type      VARCHAR(50),                   -- نوع بیمه
    insurance_number    VARCHAR(20),                   -- شماره بیمه
    pension_fund        VARCHAR(50),                   -- صندوق بازنشستگی
    
    created_at          TIMESTAMP DEFAULT NOW(),
    updated_at          TIMESTAMP DEFAULT NOW()
);

-- Leave Management
CREATE TABLE leave_records (
    leave_id            SERIAL PRIMARY KEY,
    employee_id         INTEGER REFERENCES employees(employee_id),
    leave_type          VARCHAR(30),     -- مرخصی استحقاقی/استعلاجی/بدون حقوق/زایمان/سفر
    start_date          DATE NOT NULL,
    end_date            DATE NOT NULL,
    days_count          INTEGER,
    reason              TEXT,
    approved_by         INTEGER REFERENCES employees(employee_id),
    approval_date       DATE,
    status              VARCHAR(20)     -- pending/approved/rejected
);

-- Attendance Tracking
CREATE TABLE attendance (
    attendance_id       SERIAL PRIMARY KEY,
    employee_id         INTEGER REFERENCES employees(employee_id),
    date                DATE NOT NULL,
    check_in_time       TIME,
    check_out_time      TIME,
    hours_worked        DECIMAL(4,2),
    overtime_hours      DECIMAL(4,2),
    attendance_type     VARCHAR(20),     -- present/absent/late/half_day/mission
    notes               TEXT
);

-- Training Records
CREATE TABLE training_records (
    training_id         SERIAL PRIMARY KEY,
    employee_id         INTEGER REFERENCES employees(employee_id),
    course_name         VARCHAR(200),
    course_type         VARCHAR(50),     -- آموزش حین خدمت/بازآموزی/تکمیلی
    provider            VARCHAR(100),
    start_date          DATE,
    end_date            DATE,
    hours               INTEGER,
    certificate_received BOOLEAN DEFAULT FALSE,
    score               DECIMAL(5,2)
);
```

---

## 5. HEALTH SERVICE DELIVERY SYSTEM

### 5.1 Referral System Flow (نظام ارجاع)

```
Community Level (خانه بهداشت / پایگاه سلامت)
│ بهورز/بهداشتکار performs initial assessment
│ Basic treatment, health education, referrals
│
├── Self-care / Home management
│
▼
First Level: مرکز جامع سلامت (Comprehensive Health Center)
│ GP consultation, basic diagnostics
│ Maternal/child health services
│ Dental services
│
├── Continue at this level
│
▼
Second Level: بیمارستان (Hospital) / پلی‌کلینیک تخصصی
│ Specialist consultation
│ Diagnostic imaging
│ Basic surgery
│
├── Continue at this level
│
▼
Third Level: بیمارستان آموزشی (Teaching Hospital)
│ Subspecialty care
│ Advanced diagnostics
│ Complex surgery
│ ICU
│
▼
Fourth Level: مراکز مرجع (Referral Centers)
│ National specialized centers
│ Advanced treatment modalities
```

### 5.2 Service Packages by Level

#### Health House (خانه بهداشت) Services:
1. ثبت خانوار (Household Registration)
2. مراقبت مادران باردار (Prenatal Care)
3. مراقبت بعد از زایمان (Postnatal Care)
4. رشد کودکان (Child Growth Monitoring)
5. واکسیناسیون (Vaccination - EPI)
6. بهداشت باروری (Reproductive Health)
7. کنترل بیماری‌های واگیردار (Communicable Disease Surveillance)
8. آموزش بهداشت (Health Education)
9. بهداشت محیط روستا (Rural Environmental Health)
10. مراقبت سالمندان (Elderly Care)
11. مراقبت بیماری‌های مزمن (Chronic Disease Follow-up)
12. اقدامات اورژانسی اولیه (Basic Emergency Care)

#### Comprehensive Health Center Services:
All Health House services PLUS:
1. ویزیت پزشک عمومی (GP Consultation)
2. خدمات دندانپزشکی (Dental Services)
3. آزمایشگاه (Laboratory)
4. داروخانه (Pharmacy)
5. مامایی تخصصی (Specialist Midwifery)
6. سونوگرافی (Ultrasound)
7. اقدامات تشخیصی (Diagnostic Services)
8. واکسیناسیون سفر (Travel Vaccination)
9. درمان سرپایی (Outpatient Treatment)
10. مشاوره تغذیه (Nutrition Counseling)
11. مشاوره سلامت روان (Mental Health Counseling)
12. بهداشت حرفه‌ای (Occupational Health)

### 5.3 Key Health Programs (برنامه‌های سلامت)

| Program Code | Persian Name | English Name | Key Indicators |
|-------------|-------------|-------------|----------------|
| HP-01 | برنامه سلامت مادران | Maternal Health Program | ANC coverage, Skilled birth attendance, Maternal mortality |
| HP-02 | برنامه سلامت کودکان | Child Health Program | Full vaccination rate, Growth monitoring coverage |
| HP-03 | برنامه تنظیم خانواده | Family Planning Program | Contraceptive prevalence rate |
| HP-04 | برنامه مبارزه با سل | TB Control Program | Case detection rate, Treatment success rate |
| HP-05 | برنامه مبارزه با مالاریا | Malaria Control Program | Slide positivity rate |
| HP-06 | برنامه مدیریت دیابت و فشار خون | DM/HTN Management Program | Screening rate, Control rate |
| HP-07 | برنامه بهداشت مدارس | School Health Program | Health inspection coverage |
| HP-08 | برنامه سلامت روان | Mental Health Program | PHQ-9 screening rate |
| HP-09 | برنامه تغذیه | Nutrition Program | Exclusive breastfeeding rate, Stunting prevalence |
| HP-10 | برنامه بهداشت محیط | Environmental Health Program | Water quality compliance, Food safety inspection rate |
| HP-11 | برنامه حفاظت از محیط زیست | Environmental Protection Program | Waste management compliance |
| HP-12 | برنامه اورژانس و مدیریت بحران | Emergency & Crisis Management Program | Response time, Preparedness score |
| HP-13 | برنامه پیشگیری از اعتیاد | Substance Abuse Prevention Program | Awareness rate, Treatment completion |
| HP-14 | برنامه سلامت سالمندان | Elderly Health Program | Screening coverage |
| HP-15 | برنامه سلامت نوجوانان | Adolescent Health Program | Coverage, Awareness |
| HP-16 | برنامه بهداشت دهان و دندان | Oral Health Program | DMFT index, Dental visit rate |

---

## 6. DATA FIELDS FOR EACH UNIT (DETAILED)

### 6.1 Patient/Client Master Data

```sql
-- Central Patient Registry (سیب ID based)
CREATE TABLE patients (
    patient_id          SERIAL PRIMARY KEY,
    sib_id              VARCHAR(20) UNIQUE,           -- شناسه سیب
    national_code       VARCHAR(10),                  -- کد ملی
    first_name_fa       VARCHAR(50),
    last_name_fa        VARCHAR(50),
    father_name_fa      VARCHAR(50),
    birth_date          DATE,
    gender              VARCHAR(10),
    blood_type          VARCHAR(5),                   -- گروه خون
    marital_status      VARCHAR(20),
    
    -- Address
    province            VARCHAR(50),
    city                VARCHAR(50),
    rural_urban         VARCHAR(10),
    address_full        TEXT,
    postal_code         VARCHAR(10),
    geomarketing_code   VARCHAR(20),                  -- کد ژئومارکتینگ (geohash)
    
    -- Catchment
    health_house_id     INTEGER,                      -- خانه بهداشت
    health_base_id      INTEGER,                      -- پایگاه سلامت
    comprehensive_id     INTEGER,                     -- مرکز جامع سلامت
    network_id          INTEGER,                      -- شبکه بهداشت
    
    -- Insurance
    insurance_type      VARCHAR(50),                  -- تامین اجتماعی/سلامت/ایثارگران/آزاد
    insurance_number    VARCHAR(20),
    insurance_expiry    DATE,
    
    -- Contact
    mobile              VARCHAR(15),
    phone               VARCHAR(15),
    
    -- Household
    household_id        INTEGER,
    family_role         VARCHAR(20),                  -- head/spouse/child/other
    
    -- Status
    is_active           BOOLEAN DEFAULT TRUE,
    death_date          DATE,
    death_cause         VARCHAR(200),
    migration_out       BOOLEAN DEFAULT FALSE,
    
    created_at          TIMESTAMP DEFAULT NOW(),
    updated_at          TIMESTAMP DEFAULT NOW()
);

-- Household Registry
CREATE TABLE households (
    household_id        SERIAL PRIMARY KEY,
    household_code      VARCHAR(20),
    head_of_household   INTEGER REFERENCES patients(patient_id),
    household_size      INTEGER,
    address_full        TEXT,
    geomarketing_code   VARCHAR(20),
    housing_type        VARCHAR(30),                  -- permanently/temporary
    ownership           VARCHAR(20),                  -- owned/rented
    water_source        VARCHAR(30),                  -- piped/well/spring/other
    sanitation_type     VARCHAR(30),                  -- toilet/septic/other
    electricity         BOOLEAN,
    gas                 BOOLEAN,
    cooking_fuel        VARCHAR(20),
    income_level        VARCHAR(20),                  -- low/middle/high
    health_house_id     INTEGER,
    network_id          INTEGER,
    created_at          TIMESTAMP DEFAULT NOW()
);
```

### 6.2 Maternal Health Data Fields

```sql
CREATE TABLE maternal_health (
    maternal_id         SERIAL PRIMARY KEY,
    patient_id          INTEGER REFERENCES patients(patient_id),
    center_id           INTEGER,
    
    -- Pregnancy
    pregnancy_no        INTEGER,                      -- شماره بارداری
    lmp_date            DATE,                         -- آخرین قاعدگی
    edd_date            DATE,                         -- تاریخ زایمان احتمالی
    pregnancy_status    VARCHAR(20),                  -- ongoing/completed/aborted
    risk_assessment     VARCHAR(20),                  -- low/moderate/high
    
    -- ANC Visits (ویزیت‌های قبل از زایمان)
    anc_visit_1_date    DATE,
    anc_visit_1_weight  DECIMAL,
    anc_visit_1_bp      VARCHAR(10),
    anc_visit_1_hemoglobin DECIMAL,
    
    anc_visit_2_date    DATE,
    anc_visit_2_weight  DECIMAL,
    anc_visit_2_bp      VARCHAR(10),
    
    anc_visit_3_date    DATE,
    anc_visit_4_date    DATE,
    anc_visit_5_date    DATE,
    anc_visit_6_date    DATE,
    anc_visit_7_date    DATE,
    anc_visit_8_date    DATE,
    
    total_anc_visits    INTEGER,
    anc_completed       BOOLEAN,
    
    -- Lab Tests
    hiv_test_done       BOOLEAN,
    hiv_test_date       DATE,
    hiv_test_result     VARCHAR(10),
    hb_test_done        BOOLEAN,
    hb_result           DECIMAL,
    rubella_test        BOOLEAN,
    rubella_result      VARCHAR(10),
    hepatitis_b_test    BOOLEAN,
    hepatitis_b_result  VARCHAR(10),
    ultrasound_count    INTEGER,
    
    -- Supplements
    iron_supplementation BOOLEAN DEFAULT FALSE,
    folic_acid          BOOLEAN DEFAULT FALSE,
    
    -- Delivery
    delivery_date       DATE,
    delivery_type       VARCHAR(20),                  -- normal/cesarean/assisted
    delivery_location   VARCHAR(30),                  -- home/health_center/hospital/other
    delivery_attendant  VARCHAR(30),                  -- midwife/doctor/other
    
    -- Baby
    baby_gender         VARCHAR(10),
    baby_weight         DECIMAL,
    baby_apgar_1min     INTEGER,
    baby_apgar_5min     INTEGER,
    breastfeeding_start VARCHAR(30),                  -- within_1_hour/delayed/never
    
    -- Postnatal
    postnatal_visit_1   DATE,
    postnatal_visit_2   DATE,
    postnatal_visit_3   DATE,
    postnatal_visit_6   DATE,
    postnatal_completed BOOLEAN,
    
    -- Complications
    complications       TEXT[],
    referral_needed     BOOLEAN DEFAULT FALSE,
    referral_to         VARCHAR(200),
    
    created_at          TIMESTAMP DEFAULT NOW()
);
```

### 6.3 Child Health Data Fields

```sql
CREATE TABLE child_health (
    child_health_id     SERIAL PRIMARY KEY,
    patient_id          INTEGER REFERENCES patients(patient_id),
    center_id           INTEGER,
    
    -- Growth Monitoring
    visit_date          DATE,
    age_months          INTEGER,
    weight_kg           DECIMAL,
    weight_status       VARCHAR(20),                  -- normal/underweight/overweight
    weight_percentile   DECIMAL,
    height_cm           DECIMAL,
    height_percentile   DECIMAL,
    head_circumference  DECIMAL,
    
    -- Development
    developmental_milestones JSONB,                   -- motor, language, social milestones
    
    -- Feeding
    breastfeeding_status VARCHAR(30),                 -- exclusive/partial/none
    complementary_feeding BOOLEAN,
    feeding_practices   TEXT,
    
    -- Vaccination
    vaccination_card_verified BOOLEAN,
    
    -- Screening
    hearing_screen      VARCHAR(20),                  -- normal/abnormal/not_done
    vision_screen       VARCHAR(20),
    congenital_screen   VARCHAR(20),
    
    -- Issues
    problems_identified TEXT[],
    referrals           TEXT[],
    
    created_at          TIMESTAMP DEFAULT NOW()
);

-- Vaccination Records
CREATE TABLE vaccinations (
    vaccination_id      SERIAL PRIMARY KEY,
    patient_id          INTEGER REFERENCES patients(patient_id),
    
    -- BCG
    bcg_date            DATE,
    bcg_site            VARCHAR(20),
    bcg_batch_no        VARCHAR(30),
    
    -- OPV
    opv0_date           DATE,
    opv1_date           DATE,
    opv2_date           DATE,
    opv3_date           DATE,
    opv4_date           DATE,
    
    -- IPV
    ipv1_date           DATE,
    ipv2_date           DATE,
    ipv3_date           DATE,
    
    -- DPT/Hib/HBV
    pentavalent_1_date  DATE,
    pentavalent_2_date  DATE,
    pentavalent_3_date  DATE,
    
    -- Measles/Rubella
    mr1_date            DATE,
    mr2_date            DATE,
    
    -- Varicella
    varicella_date      DATE,
    
    -- Meningitis
    meningitis_date     DATE,
    
    -- Rotavirus
    rotavirus_1_date    DATE,
    rotavirus_2_date    DATE,
    rotavirus_3_date    DATE,
    
    -- PCV
    pcv1_date           DATE,
    pcv2_date           DATE,
    pcv3_date           DATE,
    
    -- Influenza (seasonal)
    influenza_date      DATE,
    
    -- Coverage Status
    epi_complete        BOOLEAN DEFAULT FALSE,
    missed_doses        TEXT[],
    
    created_at          TIMESTAMP DEFAULT NOW()
);
```

### 6.4 NCD (Non-Communicable Disease) Data Fields

```sql
-- Diabetes Screening & Management
CREATE TABLE diabetes_care (
    record_id           SERIAL PRIMARY KEY,
    patient_id          INTEGER REFERENCES patients(patient_id),
    center_id           INTEGER,
    
    -- Screening
    screening_date      DATE,
    screening_method    VARCHAR(30),
    fasting_glucose     DECIMAL,
    hba1c               DECIMAL,
    oral_glucose_tolerance DECIMAL,
    screening_result    VARCHAR(20),                  -- normal/prediabetes/diabetes
    
    -- Diagnosis
    diagnosis_date      DATE,
    diabetes_type       VARCHAR(20),                  -- type1/type2/gestational/other
    
    -- Management
    current_fbs         DECIMAL,
    current_hba1c       DECIMAL,
    last_checkup_date   DATE,
    medication          TEXT[],
    insulin_use         BOOLEAN,
    
    -- Complications Screening
    retinopathy_screen  VARCHAR(20),
    nephropathy_screen  VARCHAR(20),
    neuropathy_screen   VARCHAR(20),
    foot_exam_done      BOOLEAN,
    
    -- Follow-up
    next_checkup_date   DATE,
    referral_needed     BOOLEAN,
    compliance_level    VARCHAR(20),                  -- good/moderate/poor
    
    created_at          TIMESTAMP DEFAULT NOW()
);

-- Hypertension Screening & Management
CREATE TABLE hypertension_care (
    record_id           SERIAL PRIMARY KEY,
    patient_id          INTEGER REFERENCES patients(patient_id),
    center_id           INTEGER,
    
    -- Screening
    screening_date      DATE,
    systolic_bp         INTEGER,
    diastolic_bp        INTEGER,
    bp_category         VARCHAR(20),                  -- normal/elevated/stage1/stage2/crisis
    
    -- Management
    diagnosis_date      DATE,
    medication          TEXT[],
    last_checkup_date   DATE,
    target_bp           VARCHAR(10),
    
    -- Follow-up
    next_checkup_date   DATE,
    referral_needed     BOOLEAN,
    compliance_level    VARCHAR(20),
    
    created_at          TIMESTAMP DEFAULT NOW()
);
```

### 6.5 Environmental Health Data Fields

```sql
CREATE TABLE environmental_inspections (
    inspection_id       SERIAL PRIMARY KEY,
    center_id           INTEGER,
    inspector_id        INTEGER REFERENCES employees(employee_id),
    
    -- Facility Info
    facility_name       VARCHAR(200),
    facility_type       VARCHAR(50),                  -- restaurant/bakery/dairy/deli/food_production/market
    facility_address    TEXT,
    license_number      VARCHAR(20),
    
    -- Inspection Details
    inspection_date     DATE,
    inspection_type     VARCHAR(30),                  -- routine/followup/complaint/new_license
    
    -- Scores
    overall_score       DECIMAL(5,2),
    hygiene_score       DECIMAL(5,2),
    structural_score    DECIMAL(5,2),
    operational_score   DECIMAL(5,2),
    
    -- Findations
    violations          JSONB,                        -- [{code, description, severity, photo}]
    corrective_actions  JSONB,
    compliance_status   VARCHAR(20),                  -- compliant/non_compliant/partial
    
    -- Water Testing
    water_source        VARCHAR(50),
    water_chlorine      DECIMAL,
    water_ph            DECIMAL,
    water_turbidity     DECIMAL,
    water_coliform      INTEGER,
    water_compliance    BOOLEAN,
    
    -- Next Steps
    next_inspection     DATE,
    closure_date        DATE,
    
    created_at          TIMESTAMP DEFAULT NOW()
);

-- Waste Management
CREATE TABLE waste_management (
    waste_id            SERIAL PRIMARY KEY,
    facility_id         INTEGER,
    center_id           INTEGER,
    
    waste_type          VARCHAR(30),                  -- medical/general/infectious/sharps/pharmaceutical
    generation_date     DATE,
    quantity_kg         DECIMAL,
    disposal_method     VARCHAR(30),                  -- incineration/sanitary_landfill/recycling
    disposal_company    VARCHAR(100),
    manifest_no         VARCHAR(30),
    treatment_done      BOOLEAN,
    
    created_at          TIMESTAMP DEFAULT NOW()
);
```

### 6.6 Drug & Pharmacy Data Fields

```sql
CREATE TABLE drug_inventory (
    drug_id             SERIAL PRIMARY KEY,
    drug_code           VARCHAR(20),
    drug_name_fa        VARCHAR(200),
    drug_name_en        VARCHAR(200),
    generic_name        VARCHAR(200),
    category            VARCHAR(50),
    form                VARCHAR(30),                  -- tablet/capsule/syrup/injection/cream
    strength            VARCHAR(50),
    manufacturer        VARCHAR(100),
    country_of_origin   VARCHAR(50),
    
    quantity_in_stock   INTEGER,
    minimum_stock       INTEGER,
    maximum_stock       INTEGER,
    unit_price          DECIMAL,
    
    expiry_date         DATE,
    batch_number        VARCHAR(50),
    storage_conditions  VARCHAR(100),
    
    center_id           INTEGER,
    warehouse_location  VARCHAR(50),
    
    created_at          TIMESTAMP DEFAULT NOW(),
    updated_at          TIMESTAMP DEFAULT NOW()
);

CREATE TABLE prescriptions (
    prescription_id     SERIAL PRIMARY KEY,
    patient_id          INTEGER REFERENCES patients(patient_id),
    doctor_id           INTEGER REFERENCES employees(employee_id),
    center_id           INTEGER,
    prescription_date   DATE,
    
    medications         JSONB,                        -- [{drug_name, dosage, frequency, duration, instructions}]
    
    insurance_approval  BOOLEAN,
    dispensed           BOOLEAN,
    dispensed_date      DATE,
    pharmacist_id       INTEGER REFERENCES employees(employee_id),
    
    created_at          TIMESTAMP DEFAULT NOW()
);
```

### 6.7 Facility & Asset Data Fields

```sql
CREATE TABLE health_centers (
    center_id           SERIAL PRIMARY KEY,
    center_code         VARCHAR(20) UNIQUE,
    center_name_fa      VARCHAR(200),
    center_name_en      VARCHAR(200),
    center_type         VARCHAR(30),                  -- county/comprehensive/health_house/health_base
    network_id          INTEGER,
    parent_center_id    INTEGER,
    
    -- Location
    province            VARCHAR(50),
    county              VARCHAR(50),
    city                VARCHAR(50),
    rural_area          VARCHAR(100),
    address_full        TEXT,
    latitude            DECIMAL(10,7),
    longitude           DECIMAL(10,7),
    geomarketing_code   VARCHAR(20),
    
    -- Facility Info
    building_area_m2    DECIMAL,
    land_area_m2        DECIMAL,
    construction_year   INTEGER,
    renovation_year     INTEGER,
    ownership_type      VARCHAR(30),                  -- government/leased/private
    building_status     VARCHAR(20),                  -- good/needs_renovation/poor
    
    -- Capacity
    population_served   INTEGER,
    coverage_area_km2   DECIMAL,
    
    -- Services
    services_offered    TEXT[],                       -- list of available services
    
    -- Infrastructure
    has_lab             BOOLEAN DEFAULT FALSE,
    has_pharmacy        BOOLEAN DEFAULT FALSE,
    has_dental          BOOLEAN DEFAULT FALSE,
    has_ultrasound      BOOLEAN DEFAULT FALSE,
    has_radiology       BOOLEAN DEFAULT FALSE,
    has_emergency       BOOLEAN DEFAULT FALSE,
    has_water_supply    BOOLEAN DEFAULT TRUE,
    has_sewage_system   BOOLEAN DEFAULT TRUE,
    has_electricity     BOOLEAN DEFAULT TRUE,
    has_gas             BOOLEAN DEFAULT FALSE,
    has_internet        BOOLEAN DEFAULT FALSE,
    has_backup_power    BOOLEAN DEFAULT FALSE,
    has_cold_chain      BOOLEAN DEFAULT FALSE,
    
    -- Fleet
    vehicle_count       INTEGER DEFAULT 0,
    
    -- Status
    operational_status  VARCHAR(20) DEFAULT 'active',
    established_date    DATE,
    
    created_at          TIMESTAMP DEFAULT NOW(),
    updated_at          TIMESTAMP DEFAULT NOW()
);

CREATE TABLE facility_assets (
    asset_id            SERIAL PRIMARY KEY,
    asset_code          VARCHAR(20),
    center_id           INTEGER REFERENCES health_centers(center_id),
    asset_name          VARCHAR(200),
    asset_type          VARCHAR(50),                  -- medical_equipment/furniture/vehicle/it_equipment/other
    category            VARCHAR(50),
    brand               VARCHAR(100),
    model               VARCHAR(100),
    serial_number       VARCHAR(100),
    
    purchase_date       DATE,
    purchase_price      DECIMAL,
    warranty_expiry     DATE,
    
    current_condition   VARCHAR(20),                  -- excellent/good/fair/poor/defunct
    last_maintenance    DATE,
    next_maintenance    DATE,
    location            VARCHAR(100),
    
    depreciation_rate   DECIMAL,
    current_value       DECIMAL,
    
    assigned_to         INTEGER REFERENCES employees(employee_id),
    
    created_at          TIMESTAMP DEFAULT NOW(),
    updated_at          TIMESTAMP DEFAULT NOW()
);
```

### 6.8 Transportation & Fleet Data Fields

```sql
CREATE TABLE vehicles (
    vehicle_id          SERIAL PRIMARY KEY,
    plate_number        VARCHAR(20) UNIQUE,
    vehicle_type        VARCHAR(30),                  -- ambulance/car/van/truck/motorcycle
    brand               VARCHAR(50),
    model               VARCHAR(50),
    year                INTEGER,
    color               VARCHAR(20),
    fuel_type           VARCHAR(20),                  -- gasoline/diesel/cng/electric
    
    center_id           INTEGER REFERENCES health_centers(center_id),
    assigned_driver     INTEGER REFERENCES employees(employee_id),
    
    insurance_number    VARCHAR(30),
    insurance_expiry    DATE,
    inspection_expiry   DATE,
    
    current_mileage     INTEGER,
    condition           VARCHAR(20),
    
    created_at          TIMESTAMP DEFAULT NOW(),
    updated_at          TIMESTAMP DEFAULT NOW()
);

CREATE TABLE vehicle_maintenance (
    maintenance_id      SERIAL PRIMARY KEY,
    vehicle_id          INTEGER REFERENCES vehicles(vehicle_id),
    maintenance_type    VARCHAR(30),                  -- routine/repair/emergency/inspection
    description         TEXT,
    service_date        DATE,
    mileage_at_service  INTEGER,
    cost                DECIMAL,
    service_provider    VARCHAR(100),
    next_service_mileage INTEGER,
    next_service_date   DATE,
    
    created_at          TIMESTAMP DEFAULT NOW()
);

CREATE TABLE fuel_logs (
    log_id              SERIAL PRIMARY KEY,
    vehicle_id          INTEGER REFERENCES vehicles(vehicle_id),
    date                DATE,
    fuel_type           VARCHAR(20),
    quantity_liters     DECIMAL,
    cost                DECIMAL,
    odometer_reading    INTEGER,
    driver_id           INTEGER REFERENCES employees(employee_id),
    center_id           INTEGER,
    
    created_at          TIMESTAMP DEFAULT NOW()
);

CREATE TABLE trip_logs (
    trip_id             SERIAL PRIMARY KEY,
    vehicle_id          INTEGER REFERENCES vehicles(vehicle_id),
    driver_id           INTEGER REFERENCES employees(employee_id),
    start_date          DATE,
    start_time          TIME,
    end_date            DATE,
    end_time            TIME,
    start_location      VARCHAR(200),
    end_location        VARCHAR(200),
    purpose             VARCHAR(100),
    passengers_count    INTEGER,
    start_odometer      INTEGER,
    end_odometer        INTEGER,
    distance_km         INTEGER,
    fuel_consumed       DECIMAL,
    trip_type           VARCHAR(30),                  -- patient_transfer/supply/facility_visit/emergency/other
    
    created_at          TIMESTAMP DEFAULT NOW()
);
```

---

## 7. STANDARD FORMS & WORKFLOWS

### 7.1 Standard Forms (فرم‌های استاندارد)

| Form Code | Persian Name | English Name | Used By | Frequency |
|-----------|-------------|-------------|---------|-----------|
| F-001 | فرم ثبت خانوار | Household Registration Form | بهورز/بهداشتکار | As needed |
| F-002 | فرم مراقبت مادران باردار | Prenatal Care Form | ماما/بهورز | Each visit |
| F-003 | فرم مراقبت بعد از زایمان | Postnatal Care Form | ماما | Each visit |
| F-004 | فرم رشد کودک | Child Growth Monitoring Form | بهورز/بهداشتکار | Monthly |
| F-005 | فرم واکسیناسیون | Vaccination Card/Form | ماما/بهورز | Per dose |
| F-006 | فرم تنظیم خانواده | Family Planning Form | ماما/پزشک | Per visit |
| F-007 | فرم غربالگری دیابت | Diabetes Screening Form | پزشک/بهداشتکار | Annually |
| F-008 | فرم غربالگری فشار خون | Hypertension Screening Form | پزشک/بهداشتکار | Per visit |
| F-009 | فرم بازرسی بهداشت محیط | Environmental Health Inspection Form | بهداشتکار محیط | Monthly |
| F-010 | فرم بازرسی مواد غذایی | Food Safety Inspection Form | بهداشتکار محیط | Monthly |
| F-011 | فرم گزارش بیماری واگیردار | Communicable Disease Report Form | بهداشتکار/پزشک | Per case |
| F-012 | فرم ثبت مرگ | Death Registration Form | پزشک/ماما | Per case |
| F-013 | فرم ثبت تولد | Birth Registration Form | ماما | Per birth |
| F-014 | فرم نسخه | Prescription Form | پزشک | Per visit |
| F-015 | فرم ارجاع | Referral Form | پزشک/بهورز | Per referral |
| F-016 | فرم درخواست آزمایش | Lab Test Request Form | پزشک | Per test |
| F-017 | فرم بهداشت مدارس | School Health Form | بهداشتکار مدارس | Per inspection |
| F-018 | فرم سلامت روان | Mental Health Assessment Form | کارشناس سلامت روان | Per assessment |
| F-019 | فرم تغذیه | Nutrition Assessment Form | کارشناس تغذیه | Per assessment |
| F-020 | فرم بهداشت حرفه‌ای | Occupational Health Form | بهداشتکار حرفه‌ای | Per assessment |
| F-021 | فرم گزارش ماهانه شبکه | Monthly Network Report Form | مدیر مرکز | Monthly |
| F-022 | فرم خرید و تدارکات | Procurement Request Form | واحدها | As needed |
| F-023 | فرم مرخصی | Leave Application Form | کارکنان | As needed |
| F-024 | فرم ماموریت اداری | Official Mission/Travel Form | کارکنان | As needed |
| F-025 | فرم ارزیابی عملکرد | Performance Evaluation Form | مدیران | Quarterly |

### 7.2 Key Workflows

#### Workflow 1: Patient Registration & Visit Flow
```
1. Patient arrives at center
2. Reception: Register/lookup patient (national_code/sib_id)
3. Insurance verification
4. Queue assignment (نوبت‌دهی)
5. Clinical encounter:
   a. Vitals measurement (nurse/technician)
   b. Doctor consultation
   c. Order diagnostics (if needed)
   d. Prescription
   e. Referral (if needed)
6. Pharmacy dispensing
7. Payment/insurance processing
8. Follow-up scheduling
9. Data entry into SIB system
```

#### Workflow 2: Monthly Reporting Flow
```
1. Daily: All units enter data into SIB
2. End of month: 
   a. Each unit compiles monthly indicators
   b. Statistics unit aggregates data
   c. Quality check on data
3. Week 1 of next month:
   a. Monthly report compilation (فرم گزارش ماهانه شبکه)
   b. Technical deputy review
   c. Center director approval
4. Submission to university within deadline
5. University aggregation for provincial/national reporting
```

#### Workflow 3: Disease Surveillance Flow
```
1. Case detection at any level
2. Reporting within 24 hours (communicable diseases)
   a. Fill فرم گزارش بیماری واگیردار
   b. Enter into SIB disease module
   c. Notify county health center
3. Investigation:
   a. Contact tracing
   b. Epidemiological investigation
   c. Sample collection (if applicable)
4. Response:
   a. Treatment initiation
   b. Isolation/quarantine (if needed)
   c. Community notification (if outbreak)
5. Follow-up and closure
6. Reporting chain: Health House → Comprehensive Center → County → Province → National CDC
```

#### Workflow 4: Maternal Health Tracking Flow
```
1. Registration: Register pregnant woman at health house/base
2. Risk Assessment: Initial risk stratification
3. Prenatal Care: 
   a. Minimum 8 visits recommended
   b. Each visit: weight, BP, fundal height, fetal heart rate
   c. Lab tests at appropriate intervals
   d. Supplements (iron, folic acid)
4. Delivery Planning:
   a. Birth preparedness counseling
   b. Birth plan documentation
   c. Transportation arrangement
5. Delivery: At appropriate facility
6. Postnatal:
   a. Day 1, 3, 7, 28, 42 follow-ups
   b. Breastfeeding support
   c. Contraception counseling
7. Baby: Vaccination, growth monitoring
```

#### Workflow 5: Drug Supply Chain Flow
```
1. Inventory Check: Monthly stock count
2. Requisition: 
   a. Identify needs based on consumption
   b. Submit فرم درخواست دارو
   c. County health center approval
3. Procurement:
   a. County warehouse → Provincial warehouse
   b. Or direct from manufacturer (through داروخانه مرکزی)
4. Receipt & Storage:
   a. Quality check on receipt
   b. Entry into inventory system
   c. Proper storage (cold chain if needed)
5. Distribution:
   a. To lower-level facilities as needed
   b. Track consumption
6. Dispensing:
   a. Prescription verification
   b. Dispensing with instructions
   c. Insurance processing
```

#### Workflow 6: Employee Management Flow
```
1. Recruitment Request:
   a. Unit identifies staffing need
   b. Submit request to HR
   c. Budget verification
2. Hiring:
   a. For permanent: Through government hiring process
   b. For contract: Local hiring process
   c. For طرح: Assignment from university
3. Onboarding:
   a. Document collection
   b. System access setup
   c. Orientation training
4. Daily Management:
   a. Attendance tracking
   b. Leave management
   c. Task assignment
5. Performance:
   a. Quarterly evaluations
   b. Training records
   c. Discipline records
6. Offboarding:
   a. Clearance process
   b. Handover
   c. System access removal
```

---

## 8. EXISTING IRANIAN HEALTH MANAGEMENT SOFTWARE

### 8.1 سیب (SIB - سامانه یکپارچه بهداشت)
**English:** Integrated Health Information System

**Overview:** SIB is the PRIMARY health information system used across all Iranian health centers. Developed by the IT Department of MOHME.

**Modules:**
| Module Code | Module Name (FA) | Module Name (EN) | Description |
|-------------|-----------------|-----------------|-------------|
| SIB-01 | ثبت اطلاعات خانوار | Household Registration | Complete household and member registry |
| SIB-02 | مراقبت مادران | Maternal Health | Prenatal, delivery, postnatal tracking |
| SIB-03 | رشد کودک | Child Growth | Growth monitoring, developmental milestones |
| SIB-04 | واکسیناسیون | Vaccination | EPI vaccine tracking |
| SIB-05 | تنظیم خانواده | Family Planning | Contraception services tracking |
| SIB-06 | بیماری‌های واگیردار | Communicable Diseases | Surveillance and case management |
| SIB-07 | بیماری‌های غیرواگیر | NCD | Diabetes, hypertension screening & management |
| SIB-08 | بهداشت مدارس | School Health | Student health records |
| SIB-09 | سلامت روان | Mental Health | Mental health screening & referral |
| SIB-10 | بهداشت محیط | Environmental Health | Inspections, water testing, food safety |
| SIB-11 | آمار و گزارش‌دهی | Statistics & Reporting | Indicator calculation, report generation |
| SIB-12 | تغذیه | Nutrition | Nutrition assessment and tracking |

**Key Features:**
- Biometric identification (fingerprints, face recognition)
- National patient ID (شناسه سیب)
- Real-time data synchronization
- Mobile application for بهورز (field data collection)
- Indicator dashboard
- Reporting to provincial and national levels
- Integration with death/birth registration system

**Data Flow:**
```
Health House (بهورز enters via mobile app)
    → Comprehensive Health Center (validation, aggregation)
    → County Health Center (supervision, reporting)
    → Provincial Health Center (analysis, reporting)
    → MOHME (national statistics, policy)
```

### 8.2 سامان (SAMAN)
**English:** Hospital Information System

**Overview:** SAMAN is the hospital information system used in Ministry-affiliated hospitals.

**Modules:**
- Registration & Admission (پذیرش)
- Ward Management (مدیریت بخش)
- Bed Management (مدیریت تخت)
- Pharmacy (داروخانه)
- Laboratory (آزمایشگاه)
- Radiology (رادیولوژی)
- Operating Room (اتاق عمل)
- ICU Management
- Billing & Insurance (صورتحساب و بیمه)
- Discharge (ترخیص)
- Medical Records (پرونده پزشکی)

### 8.3 Other Systems

| System | Persian Name | Purpose | User Level |
|--------|-------------|---------|------------|
| سماپ | SAMAP | Integrated Medical Education | University |
| سامانه ثبت احوال | SAB - Civil Registration | Birth/death/marriage registration | Government |
| سامانه بیمه | Insurance Systems | SSO, Salamat, etc. | Insurance |
| سیستم اتوماسیون اداری | Office Automation | Document management, correspondence | All centers |
| سامانه مدیریت انبار | Warehouse Management | Drug/supply inventory | County+ |
| سامانه انتقال خون | Blood Transfusion | Blood bank management | Hospital |
| سامانه سماد | SAMAD | Statistical reporting | MOHME |

### 8.4 SIB Technical Architecture

```
┌─────────────────────────────────────────────────────────┐
│                    CLIENT LAYER                          │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐              │
│  │ Web App  │  │ Mobile   │  │ Desktop  │              │
│  │ (Portal) │  │ (Android)│  │  (PC)    │              │
│  └────┬─────┘  └────┬─────┘  └────┬─────┘              │
└───────┼──────────────┼──────────────┼────────────────────┘
        │              │              │
┌───────┼──────────────┼──────────────┼────────────────────┐
│       ▼              ▼              ▼  API GATEWAY        │
│  ┌─────────────────────────────────────────────┐         │
│  │           REST API / Web Services           │         │
│  └─────────────────┬───────────────────────────┘         │
│                    │                                     │
│  ┌─────────────────┼───────────────────────────┐         │
│  │         APPLICATION LAYER                    │         │
│  │  ┌─────────┐ ┌──────────┐ ┌──────────────┐ │         │
│  │  │Auth     │ │Business  │ │Reporting     │ │         │
│  │  │Service  │ │Logic     │ │Engine        │ │         │
│  │  └─────────┘ └──────────┘ └──────────────┘ │         │
│  └─────────────────┬───────────────────────────┘         │
│                    │                                     │
│  ┌─────────────────┼───────────────────────────┐         │
│  │          DATABASE LAYER                      │         │
│  │  ┌──────────────────────────────────────┐   │         │
│  │  │  SQL Server / MySQL / PostgreSQL     │   │         │
│  │  │  (National + Provincial DBs)         │   │         │
│  │  └──────────────────────────────────────┘   │         │
│  └─────────────────────────────────────────────┘         │
└──────────────────────────────────────────────────────────┘

Sync Model:
- County DB (local) ←→ Provincial DB (replication)
- Provincial DB ←→ National MOHME DB (batch + real-time)
```

---

## 9. ENTITY RELATIONSHIP DIAGRAM (Key Relationships)

```
MOHME (National)
  │
  ├──1:N── University/Medical Sciences (Provincial)
  │          │
  │          ├──1:N── County Health Centers
  │          │          │
  │          │          ├──1:N── Health Networks
  │          │          │          │
  │          │          │          ├──1:N── Comprehensive Health Centers
  │          │          │          │          │
  │          │          │          │          ├──1:N── Health Houses (rural)
  │          │          │          │          │          │
  │          │          │          │          │          ├──N:1── Households
  │          │          │          │          │          │
  │          │          │          │          │          └──N:M── Patients (via visits)
  │          │          │          │          │
  │          │          │          │          ├──1:N── Health Bases (urban)
  │          │          │          │          │
  │          │          │          │          ├──1:N── Polyclinics
  │          │          │          │          │
  │          │          │          │          └──1:N── Laboratories
  │          │          │          │
  │          │          │          └──1:N── Hospitals
  │          │          │
  │          │          ├──1:N── Staff (Employees)
  │          │          │
  │          │          ├──1:N── Assets
  │          │          │
  │          │          ├──1:N── Vehicles
  │          │          │
  │          │          └──1:N── Drug Inventory
  │          │
  │          ├──1:N── Provincial Labs
  │          │
  │          └──1:N── Blood Banks
  
  Patients ──1:N── Encounters/Visits
  Patients ──1:N── Vaccination Records
  Patients ──1:N── Maternal Health Records
  Patients ──1:N── Child Health Records
  Patients ──1:N── NCD Records (Diabetes/Hypertension)
  Patients ──1:N── Prescriptions
  Patients ──1:N── Lab Results
  Patients ──1:N── Referrals
  
  Households ──N:1── Health House
  Households ──1:N── Patients
  
  Facilities ──1:N── Inspections
  Facilities ──1:N── Assets
  Facilities ──1:N── Permits
  
  Vehicles ──1:N── Maintenance Records
  Vehicles ──1:N── Fuel Logs
  Vehicles ──1:N── Trip Logs
  
  Employees ──1:N── Leave Records
  Employees ──1:N── Attendance
  Employees ──1:N── Training Records
  Employees ──1:N── Performance Evaluations
```

---

## 10. SAVEH-SPECIFIC CONSIDERATIONS

### 10.1 Geography & Demographics
- **County:** Saveh (ساوه)
- **Province:** Markazi (مرکزی)
- **Population:** ~250,000 (estimate)
- **Urban/Rural Split:** ~60% urban, ~40% rural
- **Climate:** Semi-arid, hot summers, cold winters
- **Economy:** Agricultural, some industrial

### 10.2 Health Network Structure for Saveh

```
مرکز بهداشت شهرستان ساوه
Saveh County Health Center
│
├── شبکه بهداشت و درمان شهر ساوه (Urban)
│   ├── مرکز جامع سلامت مرکزی ساوه
│   ├── مرکز جامع سلامت ...
│   └── پایگاه‌های سلامت متعدد
│
├── شبکه بهداشت و درمان بخش‌ها (Rural Networks)
│   ├── مرکز جامع سلامت نوبران
│   │   └── خانه‌های بهداشت متعدد
│   ├── مرکز جامع سلامت مهاجران
│   │   └── خانه‌های بهداشت متعدد
│   └── مرکز جامع سلامت ...
│       └── خانه‌های بهداشت متعدد
│
├── بیمارستان شهدای ساوه (Saveh Shahed Hospital)
├── پلی‌کلینیک تخصصی
└── لابراتوار مرکزی
```

### 10.3 Key Health Priorities for Saveh
1. **NCD Management:** High prevalence of diabetes and hypertension
2. **Maternal Health:** Ensuring skilled birth attendance in rural areas
3. **Environmental Health:** Water quality in rural areas, food safety
4. **Occupational Health:** Agricultural worker health, industrial zones
5. **Substance Abuse:** Prevention programs for youth
6. **Nutrition:** Stunting prevention in children, elderly nutrition
7. **Air Quality:** Seasonal dust storms affecting respiratory health

### 10.4 System Requirements for Saveh
- **Bilingual UI:** Persian (primary) + English
- **RTL Layout:** Right-to-left for all forms and interfaces
- **Shamsi Calendar:** Iranian Solar Hijri calendar (۱۴۰۵-۱۴۰۶) support
- **National ID Integration:** Iranian national code verification
- **SIB Compatibility:** Must integrate with existing SIB system
- **Insurance Integration:** Support for بیمه تامین اجتماعی, بیمه سلامت, بیمه ایرانیان
- **SMS Notifications:** For appointment reminders, follow-ups
- **Mobile App:** For بهورز field workers
- **Offline Capability:** For rural health houses with limited internet
- **Reporting:** Standard MOHME reporting formats
- **Data Export:** Excel, PDF for manual submissions

---

## APPENDIX A: KEY TERMINOLOGY GLOSSARY

| Persian | English | Definition |
|---------|---------|-----------|
| وزارت بهداشت | Ministry of Health (MOHME) | National health ministry |
| معاونت بهداشت | Deputy of Health | Health division of MOHME |
| شبکه بهداشت | Health Network | County-level health system |
| مرکز بهداشت شهرستان | County Health Center | County health administration |
| مرکز جامع سلامت | Comprehensive Health Center | Service delivery point |
| خانه بهداشت | Health House | Rural health facility |
| پایگاه سلامت | Health Base/Post | Urban health facility |
| بهورز | Behvarz/CHW | Community Health Worker |
| پزشک خانواده | Family Physician | GP serving community |
| ماما | Midwife | Maternal health provider |
| بهداشتکار | Health Worker | Urban health worker |
| سیب | SIB | Integrated Health Info System |
| نظام ارجاع | Referral System | Patient referral pathway |
| غربالگری | Screening | Population screening |
| مراقبت سلامت | Health Care/Monitoring | Ongoing health monitoring |
| طرح نیروی انسانی | Obligatory Service | Post-graduation service |
| قرارداد | Contract | Employment contract |
| استخدام رسمی | Permanent Employment | Civil service |
| استخدام پیمانی | Contract Employment | Fixed-term contract |
| برنامه سلامت | Health Program | National health initiative |
| شاخص بهداشتی | Health Indicator | Measurable health metric |
| حلقه کیفیت | Quality Circle | Quality improvement team |
| همایش سلامت | Health Assembly | Community health meeting |

---

## APPENDIX B: COMMON HEALTH INDICATORS

| Indicator Code | Indicator Name | Formula | Reporting Frequency |
|---------------|---------------|---------|-------------------|
| IND-01 | ANC Coverage (%) | (Pregnant women with 8+ visits / Total pregnant) × 100 | Monthly |
| IND-02 | Skilled Birth Attendance (%) | (Deliveries by skilled attendant / Total deliveries) × 100 | Monthly |
| IND-03 | Full Vaccination Rate (%) | (Children 12-23mo fully vaccinated / Total children) × 100 | Monthly |
| IND-04 | Exclusive Breastfeeding Rate (%) | (Children <6mo exclusively breastfed / Total children <6mo) × 100 | Monthly |
| IND-05 | Contraceptive Prevalence Rate (%) | (Women using contraception / Total married women) × 100 | Quarterly |
| IND-06 | DM Screening Rate (%) | (Eligible adults screened for diabetes / Total eligible) × 100 | Monthly |
| IND-07 | HTN Screening Rate (%) | (Eligible adults screened for HTN / Total eligible) × 100 | Monthly |
| IND-08 | TB Case Detection Rate | New confirmed TB cases / Estimated TB incidence | Monthly |
| IND-09 | Growth Monitoring Coverage (%) | (Children <5 with growth record / Total children <5) × 100 | Monthly |
| IND-10 | Household Registration Rate (%) | (Registered households / Estimated total) × 100 | Quarterly |
| IND-11 | Death Registration Rate (%) | (Registered deaths / Estimated total deaths) × 100 | Monthly |
| IND-12 | Environmental Health Inspection Rate | Inspections completed / Inspections planned | Monthly |
| IND-13 | Mental Health Screening Rate | Screened individuals / Target population | Quarterly |
| IND-14 | School Health Inspection Rate | Schools inspected / Total schools | Quarterly |
| IND-15 | Stunting Prevalence (%) | (Children <5 with HAZ < -2SD / Total children) × 100 | Annually |

---

*Report compiled: July 2026*
*For: Saveh Health Center Management System*
*Source: Iranian Ministry of Health and Medical Education standards, MOHME health network guidelines, SIB system specifications*
