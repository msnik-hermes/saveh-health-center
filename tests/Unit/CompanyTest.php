<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_company_with_valid_data(): void
    {
        $company = Company::create([
            'name' => 'تست شرکت',
            'registration_number' => '123456789',
            'phone' => '09123456789',
            'email' => 'test@company.com',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('companies', ['name' => 'تست شرکت']);
        $this->assertNotNull($company->id);
        $this->assertSame('تست شرکت', $company->name);
    }

    public function test_company_requires_name(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        Company::create(['phone' => '09123456789']);
    }

    public function test_company_has_many_inspections(): void
    {
        $company = Company::create([
            'name' => 'تست شرکت',
            'status' => 'active',
        ]);

        $this->assertCount(0, $company->companyInspections);
        $this->assertCount(0, $company->hazardAssessments);
    }

    public function test_company_soft_delete(): void
    {
        $company = Company::create([
            'name' => 'تست شرکت',
            'status' => 'active',
        ]);
        $companyId = $company->id;

        $company->delete();

        $this->assertSoftDeleted('companies', ['id' => $companyId]);
        $this->assertNotNull(Company::onlyTrashed()->find($companyId));
    }

    public function test_company_filter_by_status(): void
    {
        Company::create(['name' => 'شرکت فعال', 'status' => 'active']);
        Company::create(['name' => 'شرکت غیرفعال', 'status' => 'inactive']);

        $activeCompanies = Company::where('status', 'active')->get();
        $this->assertCount(1, $activeCompanies);
        $this->assertSame('شرکت فعال', $activeCompanies->first()->name);

        $inactiveCompanies = Company::where('status', 'inactive')->get();
        $this->assertCount(1, $inactiveCompanies);
        $this->assertSame('شرکت غیرفعال', $inactiveCompanies->first()->name);
    }
}
