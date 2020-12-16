<?php

namespace Mjedari\Larafilter\Tests\Feature;

use Mjedari\Larafilter\Tests\Models\User;
use Mjedari\Larafilter\Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function seed_database()
    {
        $users = User::all()->count();
        $this->assertEquals(100, $users);
    }

    /** @test */
    public function get_active_users()
    {
        $activeUsers = User::where('active', 1)->get()->count();
        $this->assertEquals($activeUsers, 40);
    }

    /** @test */
    public function get_inactive_users()
    {
        $inactiveUsers = User::where('active', 0)->get()->count();
        $this->assertEquals($inactiveUsers, 60);
    }
}
