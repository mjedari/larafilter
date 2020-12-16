<?php

namespace Mjedari\Larafilter\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Mjedari\Larafilter\Filters\Active;
use Mjedari\Larafilter\Filters\Users\Id;
use Mjedari\Larafilter\Traits\Filterable;

class User extends Model
{
    protected $guarded = [];

    use Filterable;

    protected static $filters = [
        Active::class,
        Id::class,
    ];
}
