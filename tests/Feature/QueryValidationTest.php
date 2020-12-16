<?php

namespace Mjedari\Larafilter\Tests\Feature;

use Mjedari\Larafilter\Filters\Active;
use Mjedari\Larafilter\Tests\TestCase;
use ReflectionClass;

class QueryValidationTest extends TestCase
{
    protected string $class = Active::class;
    protected string $filterName;

    public function setUp(): void
    {
        parent::setUp();
        $reflectionClass = new ReflectionClass($this->class);
        $this->filterName = $reflectionClass->getStaticPropertyValue('queryName');
    }

    /** @test */
    public function null_boolean_query_validation()
    {
        $response = $this->get("/test-route-filter?$this->filterName=");
        $response->assertStatus(302);
        $responseMessage = $response->exception->getMessage();
        $this->assertEquals($responseMessage, "<li>The $this->filterName field is required.</li>");
    }

    /** @test */
    public function invalid_int_boolean_query_validation()
    {
        $response = $this->get("/test-route-filter?$this->filterName=12");
        $this->invalid_query_handel($response);
    }

    /** @test */
    public function invalid_string_boolean_query_validation()
    {
        $response = $this->get("/test-route-filter?$this->filterName=some-thing");
        $this->invalid_query_handel($response);
    }

    /** @test */
    public function invalid_character_boolean_query_validation()
    {
        $response = $this->get("/test-route-filter?$this->filterName=\'-/*");
        $this->invalid_query_handel($response);
    }

    protected function invalid_query_handel($response)
    {
        $response->assertStatus(302);
        $responseMessage = $response->exception->getMessage();
        $this->assertEquals($responseMessage, "<li>The selected $this->filterName is invalid.</li>");
    }
}
