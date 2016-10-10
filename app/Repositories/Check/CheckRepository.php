<?php

namespace App\Repositories\Check;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use App\Models\ExamStatus;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\UserQuestion;
use App\Repositories\Check\CheckRepositoryInterFace;
use Exception;
use DB;
use App\Repositories\BaseRepository;

class CheckRepository extends BaseRepository implements CheckRepositoryInterFace
{
    public function __construct(ExamResult $examResult)
    {
        $this->model = $examResult;
    }

    public function update($inputs, $id)
    {
        $exam = Exam::findOrFail($id);
        $user = $inputs['user'];
        $questionAnswers = $inputs['choice_text'];
        foreach ($questionAnswers as $questionAnswerId => $correct) {
            QuestionAnswer::find($questionAnswerId)->update(['correct' => $correct]);
        }

        /*score*/
        $score = config('common.exam.score_default');
        $examQuestions = $exam->examQuestions;
        $userQuestions = UserQuestion::where([
            'user_id' => $user,
            'exam_id' => $id,
        ])->pluck('question_answer_id')->toArray();
        foreach ($examQuestions as $examQuestion) {
            $type = $examQuestion->question->type;
            if ($type != config('common.question.type_question.multiple_choice')) {
                $questionAnswers = $examQuestion->question->questionAnswers;
                foreach ($questionAnswers as $questionAnswer) {
                    if ($questionAnswer->correct == config('common.question_answer.correct.answer_true')
                        && in_array($questionAnswer->id, $userQuestions)) {
                        $score++;
                        break;
                    }
                }
            }
            else {
                $questionAnswers = $examQuestion->question->questionAnswers;
                foreach ($questionAnswers as $questionAnswer) {
                    if ($questionAnswer->correct == config('common.question_answer.correct.answer_false')) {
                        $questionAnswerFalse[] = $questionAnswer->id;
                    }
                }

                for ($index = 0; $index < count($questionAnswerFalse); $index++) {
                    if (in_array($questionAnswerFalse[$index], $userQuestions)) {
                        //false
                        break;
                    } elseif ($index == count($questionAnswerFalse) - 1) {
                        //true
                        $score++;
                    }
                }
            }
        }

        ExamResult::where([
            'user_id' => $user,
            'exam_id' => $id,
        ])->update(['result' => $score]);

        ExamStatus::where([
            'user_id' => $inputs['user'],
            'exam_id' => $id,
        ])->update(['status' => config('common.exam.status.exam_checked')]);

    }
}
