<?php

use Illuminate\Support\Facades\Route;
use Mjedari\Larafilter\Filters\Active;
use Mjedari\Larafilter\Tests\Models\User;

Route::get('/test-route-filter', function () {
    return User::filter()->count();
});

Route::get('/test-route-filter-through', function () {
    return User::filterThrough([Active::class])->count();
});
