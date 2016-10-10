<?php

namespace App\Filter;

use App\QueryFilter;

class ExamFilters extends QueryFilter
{
    public function input()
    {
        return parent::filters();
    }

    public function name($input)
    {
        return $this->builder->where('name', 'LIKE', '%' . $input . '%');
    }

    public function subject($input)
    {
        return $this->builder->join('subjects', 'exams.subject_id', '=', 'subjects.id')
            ->where('subjects.name', 'LIKE', '%' . $input . '%');
    }

    public function result($input)
    {
        return $this->builder->join('exam_results', 'exams.id', '=', 'exam_results.exam_id')
            ->where('exam_results.result', $input);
    }

    public function user($input)
    {
        return $this->builder->join('exam_results', 'exams.id', '=', 'exam_results.exam_id')
            ->join('users', 'exam_results.user_id', '=', 'users.id')
            ->where('users.name', 'LIKE', '%' . $input . '%');
    }

    public function status($input)
    {
        $trans = trans('admins/exams/names.status_key');
        $config = config('common.exam.status');
        $dataSearch = $config['exam_testing'];
        switch ($input) {
            case $trans['checked']:
                $dataSearch = $config['exam_checked'];
                break;
            case $trans['unchecked']:
                $dataSearch = $config['exam_unchecked'];
                break;
            case $trans['save']:
                $dataSearch = $config['exam_save'];
                break;
        }

        return $this->builder->join('exam_statuses', 'exams.id', '=', 'exam_statuses.exam_id')
            ->where('exam_statuses.status', $dataSearch);
    }
}
