<?php

namespace Mjedari\Larafilter\Traits;

use Illuminate\Database\Eloquent\Builder;
use Mjedari\Larafilter\Facades\LaraFilter;

/**
 * @property array $filters
 * @method static Builder filter()
 * @method static Builder filterThrough(array $filters)
 */
trait Filterable
{
    public function scopeFilter(Builder $query)
    {
        $this->handel($query, static::$filters);
    }

    public function scopeFilterThrough(Builder $query, array $filters)
    {
        $this->handel($query, $filters);
    }

    protected function handel($query, $modelFilters)
    {
        $queryFilters = request()->query();

        return collect($queryFilters)->map(function ($filter, $value) use ($query) {
            // Reject if model doesn't has the filter
            $normalizedFilters = LaraFilter::normalizeFilters(self::$filters);
            if (! $normalizedFilters->get($value)) {
                return false;
            }

            // Reject if query string is empty
            if (! $filter) {
                return;
            }

            $class = $normalizedFilters->get($value);

            return (new $class())->apply($query);
        });
    }
}
