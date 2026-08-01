<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_resource_index() {
        $this->markTestSkipped('requires Filament routes setup');
    }
}
