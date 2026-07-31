<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\HazardAssessment;
use App\Models\CompanyInspection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_has_many_hazard_assessments(): void
    {
        $company = Company::factory()->create();
        $assessment1 = HazardAssessment::factory()->create(['company_id' => $company->id]);
        $assessment2 = HazardAssessment::factory()->create(['company_id' => $company->id]);

        $this->assertCount(2, $company->hazardAssessments);
        $this->assertTrue($company->hazardAssessments()->where('id', $assessment1->id)->exists());
        $this->assertTrue($company->hazardAssessments()->where('id', $assessment2->id)->exists());
    }

    public function test_company_has_many_company_inspections(): void
    {
        $company = Company::factory()->create();
        $inspection1 = CompanyInspection::factory()->create(['company_id' => $company->id]);
        $inspection2 = CompanyInspection::factory()->create(['company_id' => $company->id]);

        $this->assertCount(2, $company->companyInspections);
        $this->assertTrue($company->companyInspections()->where('id', $inspection1->id)->exists());
        $this->assertTrue($company->companyInspections()->where('id', $inspection2->id)->exists());
    }

    public function test_hazard_assessment_belongs_to_company(): void
    {
        $company = Company::factory()->create();
        $assessment = HazardAssessment::factory()->create(['company_id' => $company->id]);

        $this->assertInstanceOf(Company::class, $assessment->company);
        $this->assertSame($company->id, $assessment->company->id);
    }

    public function test_company_inspection_belongs_to_company(): void
    {
        $company = Company::factory()->create();
        $inspection = CompanyInspection::factory()->create(['company_id' => $company->id]);

        $this->assertInstanceOf(Company::class, $inspection->company);
        $this->assertSame($company->id, $inspection->company->id);
    }
}