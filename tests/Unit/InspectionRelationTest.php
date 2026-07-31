<?php

namespace Tests\Unit;

use App\Models\CompanyInspection;
use App\Models\HazardAssessment;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InspectionRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_inspection_belongs_to_company(): void
    {
        $company = Company::factory()->create();
        $inspection = CompanyInspection::factory()->create(['company_id' => $company->id]);

        $this->assertInstanceOf(Company::class, $inspection->company);
        $this->assertSame($company->id, $inspection->company->id);
    }

    public function test_company_inspection_belongs_to_inspector(): void
    {
        $inspector = Employee::factory()->create();
        $inspection = CompanyInspection::factory()->create(['inspector_id' => $inspector->id]);

        $this->assertInstanceOf(Employee::class, $inspection->inspector);
        $this->assertSame($inspector->id, $inspection->inspector->id);
    }

    public function test_company_has_many_inspections(): void
    {
        $company = Company::factory()->create();
        CompanyInspection::factory()->count(3)->create(['company_id' => $company->id]);

        $this->assertCount(3, $company->companyInspections);
    }

    public function test_hazard_assessment_belongs_to_company(): void
    {
        $company = Company::factory()->create();
        $assessment = HazardAssessment::factory()->create(['company_id' => $company->id]);

        $this->assertInstanceOf(Company::class, $assessment->company);
        $this->assertSame($company->id, $assessment->company->id);
    }
}
