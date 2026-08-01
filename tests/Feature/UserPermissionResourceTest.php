<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPermissionResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_permission_resource_index() {
        $this->markTestSkipped('requires Filament routes setup');
    }
}
