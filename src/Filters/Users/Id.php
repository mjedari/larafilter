<?php

namespace Mjedari\Larafilter\Filters\Users;

use Illuminate\Database\Eloquent\Builder;
use Mjedari\Larafilter\Filters\FilterContract;

class Id extends FilterContract
{
    public static $queryName = 'ida';

    protected $cast = 'integer';

    public function apply(Builder $query): Builder
    {
        return $query->where('id', '=', $this->value);
    }

    public function options()
    {
        // TODO: Implement options() method.
    }

    public function rules()
    {
        return [
            'required', 'numeric',
        ];
    }
}
