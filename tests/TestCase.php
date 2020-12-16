<?php

namespace Mjedari\Larafilter\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Mjedari\Larafilter\LarafilterServiceProvider;
use Mjedari\Larafilter\Tests\Models\User;
use Mjedari\Larafilter\Tests\Seeder\TestSeeder;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
//        $this->withFactories(__DIR__.'/../database/factories');
//        $this->loadLaravelMigrations(['--database' => 'sqlite']);
//        dd(__DIR__ . '/Factories/');
        $this->withFactories(__DIR__.'/Factories/');
        require __DIR__.'/test-route.php';
        $this->setUpDatabase();
        $this->seed(TestSeeder::class);
        Config::set('larafilter.path', 'Mjedari\Larafilter\Filters');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaraFilterServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'test_db');
        $app['config']->set('database.connections.test_db', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    protected function setUpDatabase()
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->boolean('active')->default(0);
            $table->string('password');

            $table->timestamps();
        });
    }

    protected function createUser()
    {
        User::forceCreate([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'test',
        ]);
    }
}
