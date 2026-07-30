<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'personnel_code', 'first_name', 'last_name', 'father_name', 'national_code',
    'id_card_number', 'id_card_serial', 'birth_date', 'birth_place', 'gender',
    'marital_status', 'children_count', 'blood_type', 'nationality', 'ethnicity',
    'religion', 'height_cm', 'weight_kg', 'military_service_status', 'has_disability',
    'disability_type', 'photo', 'signature', 'job_title', 'position', 'employment_type',
    'employment_date', 'end_date', 'probation_end_date', 'contract_end_date',
    'center_id', 'department', 'service_type', 'supervisor_id', 'status',
    'retirement_date', 'years_of_service', 'is_laborer', 'education_degree',
    'education_field', 'university', 'graduation_year', 'gpa', 'medical_license_number',
    'license_expiry', 'certifications', 'skills', 'home_address', 'home_postal_code',
    'home_phone', 'mobile', 'work_email', 'personal_email', 'emergency_contact',
    'emergency_phone', 'emergency_relation', 'base_salary', 'housing_allowance',
    'food_allowance', 'child_allowance', 'family_allowance', 'overtime_rate',
    'insurance_type', 'insurance_number', 'pension_fund', 'military_service_years',
    'education_credit', 'work_start_time', 'work_end_time', 'weekly_schedule',
    'shift_type', 'can_telework', 'bank_account_number', 'bank_name',
    'performance_score', 'last_evaluation_date', 'training_records',
    'disciplinary_records', 'notes', 'created_by', 'updated_by',
])]
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees';

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'employment_date' => 'date',
            'end_date' => 'date',
            'probation_end_date' => 'date',
            'contract_end_date' => 'date',
            'retirement_date' => 'date',
            'license_expiry' => 'date',
            'last_evaluation_date' => 'date',
            'children_count' => 'integer',
            'height_cm' => 'decimal:1',
            'weight_kg' => 'decimal:1',
            'years_of_service' => 'decimal:1',
            'gpa' => 'decimal:2',
            'base_salary' => 'decimal:2',
            'housing_allowance' => 'decimal:2',
            'food_allowance' => 'decimal:2',
            'child_allowance' => 'decimal:2',
            'family_allowance' => 'decimal:2',
            'overtime_rate' => 'decimal:2',
            'military_service_years' => 'decimal:1',
            'education_credit' => 'decimal:1',
            'performance_score' => 'decimal:2',
            'work_start_time' => 'datetime:H:i',
            'work_end_time' => 'datetime:H:i',
            'has_disability' => 'boolean',
            'is_laborer' => 'boolean',
            'can_telework' => 'boolean',
            'certifications' => 'array',
            'skills' => 'array',
            'training_records' => 'array',
            'disciplinary_records' => 'array',
        ];
    }

    // --- Center ---
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    // --- Self-referencing (supervisor) ---
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'supervisor_id');
    }

    // --- User ---
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    // --- HR ---
    public function contracts(): HasMany
    {
        return $this->hasMany(EmployeeContract::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function leaveRecords(): HasMany
    {
        return $this->hasMany(LeaveRecord::class);
    }

    public function leaveApprovals(): HasMany
    {
        return $this->hasMany(LeaveRecord::class, 'approved_by');
    }

    public function leaveReplacements(): HasMany
    {
        return $this->hasMany(LeaveRecord::class, 'replacement_id');
    }

    public function performanceEvaluations(): HasMany
    {
        return $this->hasMany(PerformanceEvaluation::class);
    }

    public function evaluationsGiven(): HasMany
    {
        return $this->hasMany(PerformanceEvaluation::class, 'evaluator_id');
    }

    public function staffTransfers(): HasMany
    {
        return $this->hasMany(StaffTransfer::class);
    }

    public function transferRequests(): HasMany
    {
        return $this->hasMany(StaffTransfer::class, 'requested_by');
    }

    // --- Driver ---
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    // --- Equipment ---
    public function custodiedEquipment(): HasMany
    {
        return $this->hasMany(CenterEquipment::class, 'custodian_id');
    }

    // --- Requests ---
    public function submittedFacilityRequests(): HasMany
    {
        return $this->hasMany(FacilityRequest::class, 'requested_by');
    }

    public function assignedFacilityRequests(): HasMany
    {
        return $this->hasMany(FacilityRequest::class, 'assigned_to');
    }

    public function submittedItRequests(): HasMany
    {
        return $this->hasMany(ItRequest::class, 'requested_by');
    }

    public function assignedItRequests(): HasMany
    {
        return $this->hasMany(ItRequest::class, 'assigned_to');
    }

    public function submittedVehicleRequests(): HasMany
    {
        return $this->hasMany(VehicleRequest::class, 'requested_by');
    }

    public function workOrdersAssigned(): HasMany
    {
        return $this->hasMany(WorkOrder::class, 'assigned_technician');
    }

    public function formSubmissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class, 'submitted_by');
    }

    public function assignedFormSubmissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class, 'assigned_to');
    }

    // --- Financial ---
    public function financialApprovals(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'approved_by');
    }

    // --- Inspections ---
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'inspector_id');
    }

    public function companyInspections(): HasMany
    {
        return $this->hasMany(CompanyInspection::class, 'inspector_id');
    }

    public function environmentalInspections(): HasMany
    {
        return $this->hasMany(EnvironmentalInspection::class, 'inspector_id');
    }

    public function healthPermits(): HasMany
    {
        return $this->hasMany(HealthPermit::class, 'inspector_id');
    }

    // --- Dental ---
    public function dentalServices(): HasMany
    {
        return $this->hasMany(DentalService::class, 'dentist_id');
    }

    // --- Mental Health ---
    public function mentalHealthClinic(): HasMany
    {
        return $this->hasMany(MentalHealthClinic::class, 'clinician_id');
    }

    // --- Security ---
    public function reportedIncidents(): HasMany
    {
        return $this->hasMany(SecurityIncident::class, 'reported_by');
    }

    // --- SIM Cards ---
    public function simCards(): HasMany
    {
        return $this->hasMany(SimCard::class, 'assigned_to');
    }

    // --- Early Retirement ---
    public function earlyRetirementCases(): HasMany
    {
        return $this->hasMany(EarlyRetirementCase::class);
    }
}
