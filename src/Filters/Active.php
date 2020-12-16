<?php

namespace Mjedari\Larafilter\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class Active extends FilterContract
{
    public $active;

    public static $queryName = 'activea';

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

    // ToDo: This is mandatory. should be fixed
    // string is only in php7.4
//    protected $cast = 'boolean';
}
