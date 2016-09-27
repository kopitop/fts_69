<?php

namespace App\Filter;

use App\QueryFilter;

class UserFilters extends QueryFilter
{
    public function input()
    {
        return parent::filters();
    }

    public function name($input)
    {
        return $this->builder->where('name', 'LIKE', '%' . $input . '%');
    }

    public function email($input)
    {
        return $this->builder->where('email', 'LIKE', '%' . $input . '%');
    }

    public function chatworkId($input)
    {
        return $this->builder->where('chatwork_id', 'LIKE', '%' . $input . '%');
    }
}
