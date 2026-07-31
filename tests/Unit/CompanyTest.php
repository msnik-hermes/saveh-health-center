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
        $data = [
            'name' => 'تست شرکت',
            'registration_number' => '123456789',
            'phone' => '09123456789',
            'email' => 'test@company.com',
            'status' => 'active',
        ];

        $company = Company::create($data);

        $this->assertDatabaseHas('companies', $data);
        $this->assertNotNull($company->id);
        $this->assertSame($data['name'], $company->name);
    }

    public function test_company_requires_name(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Company::create(['phone' => '09123456789']);
    }

    public function test_company_validation_of_phone(): void
    {
        $company = Company::create([
            'name' => 'تست شرکت',
            'phone' => '09123456789',
            'email' => 'invalid-email',
        ]);

        $this->assertDatabaseHas('companies', ['phone' => '09123456789']);
    }

    public function test_company_relationships(): void
    {
        $company = Company::create(['name' => 'تست شرکت']);

        $this->assertHasExactCount(0, $company->companyInspections());
        $this->assertHasExactCount(0, $company->hazardAssessments());
    }

    public function test_company_soft_delete(): void
    {
        $company = Company::create(['name' => 'تست شرکت']);
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
        $this->assertCount(1);
        $this->assertSame('شرکت غیرفعال', $inactiveCompanies->first()->name);
    }
}