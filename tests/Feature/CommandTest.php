<?php

namespace Mjedari\Larafilter\Tests\Feature;

use Mjedari\Larafilter\Tests\TestCase;

class CommandTest extends TestCase
{
    /** @test */
    public function make_filter_class_command()
    {
        $this->artisan('make:filter Id')->assertExitCode(0);
    }
}
