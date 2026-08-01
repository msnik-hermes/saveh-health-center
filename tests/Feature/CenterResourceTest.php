<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CenterResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_center_resource_index() {
        $this->markTestSkipped('requires routes setup');
    }
}
