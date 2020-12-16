<?php

namespace Mjedari\Larafilter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static configNotPublished()
 */
class LaraFilter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LaraFilter';
    }
}
