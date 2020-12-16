<?php

namespace Mjedari\Larafilter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mjedari\Larafilter\Skeleton\SkeletonClass
 */
class LarafilterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'larafilter';
    }
}
