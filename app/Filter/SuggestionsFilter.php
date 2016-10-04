<?php

namespace App\Filter;

use App\QueryFilter;

class SuggestionsFilters extends QueryFilter
{
    public function input()
    {
        return parent::filters();
    }

    public function user($input)
    {
        return $this->builder->join('users', 'suggestions.user_id', '=', 'users.id')
            ->where('users.name', 'LIKE', '%' . $input . '%');
    }

    public function subject($input)
    {
        return $this->builder->join('subjects', 'suggestions.subject_id', '=', 'subjects.id')
            ->where('subjects.name', 'LIKE', '%' . $input . '%');
    }

    public function status($input)
    {
        $trans = trans('admins/suggestions/names.label_form.status');
        $config = config('common.suggestion.status');
        $data = ($input == $trans['confirm']) ? $config['confirm'] : $config['waiting'] ;
        return $this->builder->where('status', $data);
    }

    public function type($input)
    {
        $trans = trans('admins/questions/names.label_form');
        $config = config('common.question.type_question');
        $data = $config['single_choice'];

        switch ($input) {
            case $trans['multiple_choice']:
                $data = $config['multiple_choice'];
                break;
            case $trans['text']:
                $data = $config['text'];
                break;
        }

        return $this->builder->where('type', $data);
    }

    public function content($input)
    {
        return $this->builder->where('content', 'LIKE', '%' . $input . '%');
    }
}
