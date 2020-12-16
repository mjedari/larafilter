<?php

namespace Mjedari\Larafilter\Tests\Feature;

use Mjedari\Larafilter\Tests\TestCase;

class FilterTest extends TestCase
{
    /** @test */
    public function test_filter_route_works()
    {
        $response = $this->get('/test-route-filter');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_filter_through_route_works()
    {
        $response = $this->get('/test-route-filter-through');
        $response->assertStatus(200);
    }

    /** @test */
    public function use_filter_to_get_active_users()
    {
        $response = $this->get('/test-route-filter?activea=true');
        $this->assertEquals($response->getContent(), 40);
    }

    /** @test */
    public function use_filter_to_get_inactive_users()
    {
        $response = $this->get('/test-route-filter?activea=false');
        $this->assertEquals($response->getContent(), 60);
    }

    /** @test */
    public function use_filter_through_to_get_active_users()
    {
        $response = $this->get('/test-route-filter-through?activea=true');
        $this->assertEquals($response->getContent(), 40);
    }

    /** @test */
    public function use_filter_through_to_get_inactive_users()
    {
        $response = $this->get('/test-route-filter-through?activea=false');
        $this->assertEquals($response->getContent(), 60);
    }
}
