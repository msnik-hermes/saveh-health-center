<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PestSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_pest_is_configured()
    {
        $this->assertTrue(true);
    }

    public function test_database_has_tables()
    {
        $this->assertTrue(Schema::hasTable('companies'));
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasTable('roles'));
    }
}
