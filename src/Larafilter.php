<?php

namespace Mjedari\Larafilter;

class Larafilter
{
    /**
     * Check if larafilter config file has been published and set.
     *
     * @return bool
     */
    public function configNotPublished()
    {
        return is_null(config('larafilter'));
    }
}
