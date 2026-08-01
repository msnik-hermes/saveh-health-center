<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyEdgeCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_duplicate_name_allowed(): void
    {
        Company::create(['name' => 'شرکت تست', 'status' => 'active']);
        $second = Company::create(['name' => 'شرکت تست', 'status' => 'inactive']);

        $this->assertCount(2, Company::where('name', 'شرکت تست')->get());
    }

    public function test_company_soft_delete_preserves_data(): void
    {
        $company = Company::create([
            'name' => 'شرکت حذف شده',
            'registration_number' => '999999',
            'status' => 'active',
        ]);
        $id = $company->id;

        $company->delete();

        $this->assertSoftDeleted('companies', ['id' => $id]);
        $this->assertNotNull(Company::onlyTrashed()->find($id));
        $this->assertSame('شرکت حذف شده', Company::onlyTrashed()->find($id)->name);
    }

    public function test_company_restore_after_soft_delete(): void
    {
        $company = Company::create(['name' => 'شرکت موقت', 'status' => 'active']);
        $id = $company->id;

        $company->delete();
        $this->assertSoftDeleted('companies', ['id' => $id]);

        Company::onlyTrashed()->find($id)->restore();
        $this->assertDatabaseHas('companies', ['id' => $id, 'deleted_at' => null]);
    }

    public function test_company_search_by_name(): void
    {
        Company::create(['name' => 'شرکت اول بهداشت', 'status' => 'active']);
        Company::create(['name' => 'شرکت دوم درمان', 'status' => 'active']);
        Company::create(['name' => 'شرکت سوم آزمایشگاه', 'status' => 'inactive']);

        $results = Company::where('name', 'like', '%بهداشت%')->get();
        $this->assertCount(1, $results);
        $this->assertSame('شرکت اول بهداشت', $results->first()->name);
    }

    public function test_company_filter_by_multiple_statuses(): void
    {
        Company::create(['name' => 'فعال ۱', 'status' => 'active']);
        Company::create(['name' => 'فعال ۲', 'status' => 'active']);
        Company::create(['name' => 'غیرفعال', 'status' => 'inactive']);
        Company::create(['name' => 'معلق', 'status' => 'suspended']);

        $this->assertSame(2, Company::where('status', 'active')->count());
        $this->assertSame(1, Company::where('status', 'inactive')->count());
        $this->assertSame(1, Company::where('status', 'suspended')->count());
    }

    public function test_company_mass_assignment_protection(): void
    {
        $company = Company::create([
            'name' => 'تست',
            'status' => 'active',
            'created_by' => 999,
        ]);

        $this->assertNull($company->created_by);
    }

    public function test_company_empty_name_throws_error(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        Company::create(['status' => 'active']);
    }

}
