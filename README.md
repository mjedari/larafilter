![](https://raw.githubusercontent.com/mjedari/larafilter/master/art/banner.png)

# Laravel Query String Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mjedari/larafilter.svg?style=flat-square)](https://packagist.org/packages/mjedari/larafilter)
[![Build Status](https://scrutinizer-ci.com/g/mjedari/larafilter/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mjedari/larafilter/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mjedari/larafilter/badges/quality-score.png?b=master&style=flat-square)](https://scrutinizer-ci.com/g/mjedari/larafilter/?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/mjedari/larafilter.svg?style=flat-square)](https://scrutinizer-ci.com/g/mjedari/larafilter)
![PHP Tests](https://github.com/mjedari/larafilter/workflows/PHP%20Tests/badge.svg)
![PHP 8 Tests](https://github.com/mjedari/larafilter/workflows/PHP%208%20Tests/badge.svg?style=flat)
[![Total Downloads](https://img.shields.io/packagist/dt/mjedari/larafilter.svg?style=flat-square)](https://packagist.org/packages/mjedari/larafilter)


This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Quick start
#### Create a filter
```bash
php artisan make:filter country
```

#### Implement your filter logic
In the filter class which is created, implement your login in the ``apply()`` method.
In order to get query value just use ``$this->value``. We retrieved it for you from your request.
```php
...

public function apply(Builder $builder)
{
    return $builder->where('country', $this->value);
}

...
```

#### Register filter class for model
Before registering you should use ``Filterable`` trait in your model.
```php
use Filterable;
...

...

protected static $filters = [
    Country::class,
];

```
#### Use it!

```php
// All registered filtered are available through this method:

User::filter()->get();


// Only Specific registered filter is available and executable:

User::filterThrough([Country::class])->get();

```

## Installation

You can install the package via composer:

```bash
composer require mjedari/larafilter
```
Then you can publish config file:
```bash
php artisan vendor:publish --provider "Mjedari\Larafilter\LarafilterServiceProvider"
```
## Usage

### Initiation
Its simple.First create a filter by this command:
```bash
php artisan make:filter filter-name"
```
Command will create a class under the default directory ``App\Filters`` : 
```php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Mjedari\Larafilter\Filters\FilterContract;

class Active extends FilterContract
{

   public function apply(Builder $builder)
   {
       // TODO: Implement apply() method.
   }

   public function options()
   {
       // TODO: Implement options() method.
   }

   /*
   * Set rules on the query string
   */
   public function rules()
   {
       return [
           //
       ];
   }

}
```
Your filter logic would be implemented in the ``apply()`` method:
```php
public function apply(Builder $builder)
{
    return $builder->where('avtive', $this->value);
}
```
The important thing is that you have access query string value by ``$this->value`` in your filter class.

### Using

For Which model you want to filter you should add ``Filterable`` trait in it.

```php
class User extends Authenticatable
{
    use Filterable;
    .
    .
    .
    
```
Then add related filters that you created. It should be static property:

```php
use App\Filters\Active;
use App\Filters\City;

class User extends Authenticatable
{
    use Filterable;
 
    protected static $filters = [
        Active::class,
        City::class
    ];

    .
    .
    .

```

Every thing is ready. just use it in your queries:
```php
User::filter()->get();
```


if you want to specify some filter you can pass them thought this method:
```php
User::filterThrough([City::class])->get();
```

It's good to mention that this package works with query string. Ex:
```php
Route::get('/?country=germany', function() {
    return User->filter()->get();
});
```
So you should pass params through the url. The default query name is filter class name. Of course you can change the filters query name by:
 
```php

class CountryFilter extends FilterContract
{
    public static $queryName = 'country';
    .
    .
    .

```

Also, you can set rules on your query string parameters:
```php

class Active extends FilterContract
{
 
    public function rules()
    {
        return [
            'required',
            Rule::in(['true', 'false']),
        ];
    }
```
More than that sometimes we would like cast query string value. So:

```php

class Active extends FilterContract
{
    
    protected $cast = 'boolean';

    public function rules()
    {
        return [
            //
        ];
    }
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email i.jedari@gmail.com instead of using the issue tracker.

## Credits

- [Mahdi Jedari](https://github.com/mjedari)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
