<?php

namespace Mjedari\Larafilter\Tests\Feature;

use Mjedari\Larafilter\Filters\Active;
use Mjedari\Larafilter\Tests\TestCase;
use ReflectionClass;

class FilterTest extends TestCase
{
    protected string $class = Active::class;
    protected string $filterName;

    public function setUp(): void
    {
        parent::setUp();

        $reflectionClass = new ReflectionClass($this->class);
        $hasQueryName = collect($reflectionClass->getProperties())->filter(function ($property) {
            return $property->name === 'queryName' and $property->class === $this->class;
        });
        if (!$hasQueryName->isEmpty()){
            $this->filterName = $reflectionClass->getStaticPropertyValue('queryName');
        } else {
            $this->filterName = strtolower(collect(explode('\\',$this->class))->last());
        }
    }

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
        $response = $this->get("/test-route-filter?$this->filterName=true");
        $this->assertEquals($response->getContent(), 40);
    }

    /** @test */
    public function use_filter_to_get_inactive_users()
    {
        $response = $this->get("/test-route-filter?$this->filterName=false");
        $this->assertEquals($response->getContent(), 60);
    }

    /** @test */
    public function use_filter_through_to_get_active_users()
    {
        $response = $this->get("/test-route-filter-through?$this->filterName=true");
        $this->assertEquals($response->getContent(), 40);
    }

    /** @test */
    public function use_filter_through_to_get_inactive_users()
    {
        $response = $this->get("/test-route-filter-through?$this->filterName=false");
        $this->assertEquals($response->getContent(), 60);
    }
}
