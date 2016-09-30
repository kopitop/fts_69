<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionAnswer;
use Validator;
use Request;

class OptionValidator extends Validator
{
    public function option($attribute, $value, $parameters, $validator)
    {
        $data = Request::input($parameters[0]);
        $question = Question::findOrFail($data);

        if ($question->type == config('common.question.type_question.text')) {
            if (empty($value) || count($value) > 255) {
                return false;
            }
        }

        foreach ($value as $content) {
            if (empty($content)) {
                return false;
            }
        }
        return true;
    }

    public function choice($attribute, $value, $parameters, $validator)
    {
        $data = Request::input($parameters[0]);
        $question = Question::findOrFail($data);
        if ($question->type == config('common.question.type_question.text')) {
            return true;
        }

        $valueCount = array_count_values($value);
        if (!array_key_exists(config('common.question_answer.correct.answer_true'),$valueCount)) {
            return true;
        }

        $numberOfAnswerCorrect = QuestionAnswer::where([
            'question_id' => $data,
            'correct' => config('common.question_answer.correct.answer_true'),
        ])->count();

        if ($question->type == config('common.question.type_question.single_choice')) {
            if ($valueCount[config('common.question_answer.correct.answer_true')] > 1) {
                return false;
            } elseif ($numberOfAnswerCorrect >= 1
                && $valueCount[config('common.question_answer.correct.answer_true')] >= 1) {
                return false;
            }
        } elseif ($question->type == config('common.question.type_question.multiple_choice')) {
            if ($numberOfAnswerCorrect == 0
                && $valueCount[config('common.question_answer.correct.answer_true')] <= 1) {
                return false;
            }
        }

        return true;
    }
}
