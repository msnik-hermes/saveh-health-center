<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_has_many_inspections(): void
    {
        $company = Company::create([
            'name' => 'تست شرکت',
            'status' => 'active',
        ]);

        $this->assertCount(0, $company->companyInspections);
    }

    public function test_company_has_many_hazard_assessments(): void
    {
        $company = Company::create([
            'name' => 'تست شرکت',
            'status' => 'active',
        ]);

        $this->assertCount(0, $company->hazardAssessments);
    }
}
