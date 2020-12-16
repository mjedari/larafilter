<?php

namespace Mjedari\Larafilter\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function apply(Builder $builder): Builder;

    public function options();
}
