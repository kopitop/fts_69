<?php

namespace App\Repositories\Question;

use App\Models\Question;
use App\Models\Subject;
use App\Models\QuestionAnswer;
use App\Models\UserQuestion;
use Exception;
use DB;
use App\Repositories\BaseRepository;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    public function __construct(Question $question)
    {
        $this->model = $question;
    }

    public function getData()
    {
        $trans = trans('admins/questions/names.label_form');
        $config = config('common.question.type_question');
        $subjects = Subject::all()->pluck('name', 'id');
        $types = [
            $config['single_choice'] => $trans['single_choice'],
            $config['multiple_choice'] => $trans['multiple_choice'],
            $config['text'] => $trans['text'],
        ];

        return [
            'subjects' => $subjects,
            'types' => $types,
        ];
    }

    public function all()
    {
        $questions = Question::with('subject')->get();
        return $questions;
    }

    public function show($id = null)
    {
        return Question::with('subject', 'questionAnswers')->where('id', $id)->first();
    }

    public function delete($ids)
    {
        $question = Question::findOrFail($ids);

        try {
            DB::beginTransaction();
            $condition = [
                'question_id'=> $question->id,
            ];
            $questionAnswerIds = QuestionAnswer::where($condition)->pluck('id');

            /**
             * delete user questions
             */
            UserQuestion::whereIn('question_answer_id', $questionAnswerIds)->delete();

            /**
             * delete question answer
             */
            $question->questionAnswers()->delete();

            /**
             *  delete exam questions
             */
            $question->examQuestions()->delete();

            /**
             * delete question
             */
            $question->delete();
            DB::commit();
            $message = trans('messages.success.delete_success', ['item' => 'question']);
        } catch (Exception $e) {
            DB::rollBack();
            $message = trans('messages.error.delete_error', ['item' => 'question']);
        }

        return $message;
    }
}
