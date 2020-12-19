<?php

namespace Mjedari\Larafilter\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static configNotPublished()
 * @method static collection normalizeFilters(array $filters)
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
