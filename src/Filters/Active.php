<?php

namespace Mjedari\Larafilter\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class Active extends FilterContract
{
//    public static $queryName = 'activea';

    protected $cast = 'boolean';

    public function apply(Builder $query): Builder
    {
        return $query->where('active', '=', $this->value);
    }

    public function options()
    {
        // TODO: Implement options() method.
    }

    public function rules()
    {
        return [
            'required',
            Rule::in(['true', 'false']),
        ];
    }
}
