<?php

namespace Mjedari\Larafilter\Exceptions;

use Exception;

class FilterNotFound extends Exception
{
    public function __construct($filter)
    {
        parent::__construct("The given name: `{$filter}` did not match any filters");
    }
}
