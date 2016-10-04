<?php

namespace App\Filter;

use App\QueryFilter;

class QuestionAnswerFilters extends QueryFilter
{
    public function input()
    {
        return parent::filters();
    }

    public function question($input)
    {
        return $this->builder->join('questions', 'question_id', '=', 'questions.id')
            ->where('questions.content', 'LIKE', '%' . $input . '%')->where('questions.deleted_at', null);
    }

    public function correct($input)
    {
        $trans = trans('admins/questions/names.label_form');
        $config = config('common.question_answer.correct');
        $data = ($input == $trans['question_answer_true']) ? $config['answer_true'] : $config['answer_false'];

        return $this->builder->where('correct', $data);
    }

    public function content($input)
    {
        return $this->builder->where('content', 'LIKE', '%' . $input . '%');
    }
}
