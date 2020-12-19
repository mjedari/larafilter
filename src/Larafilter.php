<?php

namespace Mjedari\Larafilter;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;

class Larafilter
{
    /**
     * Check if larafilter config file has been published and set.
     * @return bool
     */
    public function configNotPublished()
    {
        return is_null(config('larafilter'));
    }

    /**
     * @param $filters
     * @return Collection
     */
    public function normalizeFilters(array $filters)
    {
        return collect($filters)->flatMap(function ($value) {
            $reflectionClass = (new ReflectionClass($value));
            $reflectionProperty = $reflectionClass->getProperty('queryName');
            if ($reflectionProperty->class === $value) {
                // here filter class has query name
                $className = $reflectionClass->getStaticPropertyValue('queryName');
            } else {
                $className = strtolower(Str::afterLast($value, '\\'));
            }

            $result[$className] = $value;

            // Reject if class doesnt exist
            if (! class_exists($value)) {
                return false;
            }

            return $result;
        });
    }
}
