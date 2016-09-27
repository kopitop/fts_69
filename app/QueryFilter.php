<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request;

    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;
    }

    public function filters()
    {
        $request =  $this->request->all();
        $searchType = config('common.search_key.search_type_key');
        $searchText = config('common.search_key.search_text_key');
        $input = [];

        if (count($request)
            && array_key_exists($searchType, $request)
            && array_key_exists($searchText, $request)
            && !empty($request[$searchType])
            && !empty($request[$searchText])) {
            $input = [
                $request[$searchType] => $request[$searchText],
            ];
        }

        return $input;
    }
}
