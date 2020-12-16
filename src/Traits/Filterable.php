<?php

namespace Mjedari\Larafilter\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use ReflectionClass;

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
            $normalizedFilters = $this->normalizeFilters();

            if (! $normalizedFilters->get($value)) {
                return false;
            }
            $class = $normalizedFilters->get($value);

            // Reject if class doesnt exist
            if (! $this->classExist($value)) {
                return false;
            }
//            dd(new $class());
            return (new $class())->apply($query);
        });
    }

    protected function getNamespace($name): string
    {
        return config('larafilter.path').'\\'.ucfirst($name);
    }

    protected function normalizeFilters()
    {
        return collect(self::$filters)->flatMap(function ($value) {
            $reflectionClass = (new ReflectionClass($value));
            $reflectionProperty = $reflectionClass->getProperty('queryName');
            if ($reflectionProperty->class === $value) {
                // here filter class has query name
                $className = $reflectionClass->getStaticPropertyValue('queryName');
            } else {
                $className = strtolower(Str::afterLast($value, '\\'));
            }

            $result[$className] = $value;

            return $result;
        });
    }

    protected function classExist($name): bool
    {
        return class_exists($this->normalizeFilters()->get($name));
    }
}
