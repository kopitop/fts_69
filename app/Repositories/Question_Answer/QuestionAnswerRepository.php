<?php

namespace App\Repositories\Question_Answer;

use App\Models\Question;
use App\Models\Subject;
use App\Models\QuestionAnswer;
use App\Models\UserQuestion;
use Exception;
use DB;
use Carbon\Carbon;
use App\Repositories\BaseRepository;

class QuestionAnswerRepository extends BaseRepository implements QuestionAnswerRepositoryInterFace
{
    public function __construct(QuestionAnswer $questionAnswer)
    {
        $this->model = $questionAnswer;
    }

    public function getData()
    {
        return Question::orderBy('created_at', config('common.sort.sort_descending'))->pluck('content', 'id');
    }

    public function store($input)
    {
        $now = Carbon::now();
        $questionId = Question::findOrFail($input['question_id']);

        if ($questionId->type != config('common.question.type_question.text')) {
            $contents = array_values($input['content']);
            $corrects = array_values($input['correct']);
            for ($index = 0; $index < count($input['content']); $index++) {
                $data[] =[
                    "question_id" => $input['question_id'],
                    "content" => $contents[$index],
                    "correct" => $corrects[$index],
                    "created_at" => $now,
                ];
            }
        } else {
            $data = [
                "question_id" => $input['question_id'],
                "content" => $input['content'][0],
                "correct" => config('common.question.type_question.text'),
                "created_at" => $now,
            ];
        }

        QuestionAnswer::insert($data);
        return (trans('messages.success.create_success', ['item' => 'answer of question']));
    }

    public function show($id = null)
    {
        return QuestionAnswer::with('question')->where('id', $id)->first();
    }
}
