<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_page_is_accessible(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }
}
