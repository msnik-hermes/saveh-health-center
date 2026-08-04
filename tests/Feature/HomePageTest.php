<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_renders_persian_branding(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('مرکز بهداشت ساوه', false)
            ->assertSee('ورود به سامانه', false);
    }
}
