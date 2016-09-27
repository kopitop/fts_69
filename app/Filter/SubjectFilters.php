<?php

namespace App\Filter;

use App\QueryFilter;

class SubjectFilters extends QueryFilter
{
    public function input()
    {
        return parent::filters();
    }

    public function name($input)
    {
        return $this->builder->where('name', 'LIKE', '%' . $input . '%');
    }

    public function duration($input)
    {
        return $this->builder->where('duration', $input);
    }

    public function numberQuestion($input)
    {
        return $this->builder->where('number_question', $input);
    }
}
