<?php

namespace App\Repositories\Question_Answer;

use App\Models\Question;
use App\Models\QuestionAnswer;
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
        return Question::where('type', '<>', config('common.question.type_question.text'))
            ->orderBy('created_at', config('common.sort.sort_descending'))
            ->pluck('content', 'id');
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

    public function update($inputs, $id)
    {
        $questionAnswer = QuestionAnswer::with('question')->findOrFail($id);
        if ($questionAnswer->question->type == config('common.question.type_question.single_choice')) {
            $condition = [
                'question_id' => $questionAnswer->question->id,
                'correct' => config('common.question_answer.correct.answer_true'),
            ];
            $answerCorrect = QuestionAnswer::where($condition)->get();

            if ($answerCorrect->count()) {
                QuestionAnswer::where($condition)->update(['correct' => config('common.question_answer.correct.answer_false')]);
            }
        }

        $questionAnswer->update($inputs);
    }

    public function delete($ids)
    {
        $questionAnswer = QuestionAnswer::findOrFail($ids);

        try {
            DB::beginTransaction();

            /**
             *  delete exam questions
             */
            $questionAnswer->userQuestions()->delete();

            /**
             * delete question answer
             */
            $questionAnswer->delete();
            DB::commit();
            $message = trans('messages.success.delete_success', ['item' => 'answer of question']);
        } catch (Exception $e) {
            DB::rollBack();
            $message = trans('messages.error.delete_error', ['item' => 'answer of question']);
        }

        return $message;
    }
}
