<?php

namespace Mjedari\Larafilter\Tests\Seeder;

use Illuminate\Database\Seeder;
use Mjedari\Larafilter\Tests\Models\User;

class TestSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 40)->create([
            'active' => 1,
        ]);
        factory(User::class, 60)->create();
    }
}
