<?php

namespace App\Filter;

use App\QueryFilter;

class QuestionFilters extends QueryFilter
{
    public function input()
    {
        return parent::filters();
    }

    public function subject($input)
    {
        return $this->builder->join('subjects', 'subject_id', '=', 'subjects.id')
            ->where('subjects.name', 'LIKE', '%' . $input . '%');
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
