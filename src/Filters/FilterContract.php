<?php

namespace Mjedari\Larafilter\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mjedari\Larafilter\Exceptions\InvalidQueryString;

abstract class FilterContract
{
    protected string $key;

    protected $value;

    protected Request $request;

    protected string $cast;

    protected static $queryName;

    public function __construct()
    {
        $this->request = request();
        $this->value = $this->request->get($this->getKey()) ?? null;
        $this->valid();
        $this->value = $this->castedAttribute();
        $this->setValue();
    }

    public function apply(Builder $builder)
    {
        //
    }

    public function options()
    {
        //
    }

    protected function calledClassName()
    {
        return strtolower(Str::afterLast(get_called_class(), '\\'));
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        // Two way:
        // there is a query name
        if (static::$queryName) {
            return static::$queryName;
        }
        // there is no query name
        return $this->calledClassName();
    }

    public function valid()
    {
        $validator = Validator::make([$this->getKey() => $this->value], $this->getRules());
        if (! $validator->passes()) {
            $messages = $this->getErrorMessages($validator->errors()->messages()[$this->getKey()]);
            throw new InvalidQueryString($messages);
        }
//        return ;
    }

    protected function rules()
    {
        return [
            'required',
        ];
    }

    private function castedAttribute()
    {
        switch ($this->cast) {
            case 'boolean':
                return strtolower($this->value) === 'true';
            case 'integer':
                return (int) $this->value;
            case 'float':
                return (float) $this->value;
            case 'double':
                return (float) $this->value;
            default:
                return $this->value;
        }
    }

    private function getErrorMessages($errors)
    {
        $result = '';
        foreach ($errors as $message) {
            $result .= '<li>'.$message.'</li>';
        }

        return $result;
    }

    protected function getRules(): array
    {
        return [
            $this->getKey() => $this->rules(),
        ];
    }

    private function setValue(): void
    {
        $propertyName = $this->getKey();
        $this->$propertyName = $this->value;
    }
}
