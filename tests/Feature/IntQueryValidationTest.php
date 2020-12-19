<?php

namespace Mjedari\Larafilter\Tests\Feature;

use Mjedari\Larafilter\Filters\Users\Id;
use Mjedari\Larafilter\Tests\TestCase;
use ReflectionClass;

class IntQueryValidationTest extends TestCase
{
    protected string $class = Id::class;
    protected string $filterName;

    public function setUp(): void
    {
        parent::setUp();

        $reflectionClass = new ReflectionClass($this->class);
        $hasQueryName = collect($reflectionClass->getProperties())->filter(function ($property) {
            return $property->name === 'queryName' and $property->class === $this->class;
        });
        if (! $hasQueryName->isEmpty()) {
            $this->filterName = $reflectionClass->getStaticPropertyValue('queryName');
        } else {
            $this->filterName = strtolower(collect(explode('\\', $this->class))->last());
        }
    }

    /** @test */
    public function null_int_query_validation()
    {
        $response = $this->get("/test-route-filter?$this->filterName=");
        $response->assertStatus(302);
        $responseMessage = $response->exception->getMessage();
        $this->assertEquals($responseMessage, "<li>The $this->filterName field is required.</li>");
    }

    /** @test */
    public function invalid_int_boolean_query_validation()
    {
        $response = $this->get("/test-route-filter?$this->filterName=1");
        $response->assertStatus(200);
        $this->assertEquals($response->getContent(), 1);
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
        $this->assertEquals($responseMessage, "<li>The $this->filterName must be a number.</li>");
    }
}
