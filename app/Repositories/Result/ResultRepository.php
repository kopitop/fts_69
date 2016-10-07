<?php

namespace App\Repositories\Result;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use App\Models\ExamStatus;
use App\Models\Question;
use App\Models\Subject;
use App\Models\QuestionAnswer;
use App\Models\UserQuestion;
use Carbon\Carbon;
use Exception;
use DB;
use App\Repositories\BaseRepository;

class ResultRepository extends BaseRepository implements ResultRepositoryInterFace
{
    public function __construct(ExamResult $examResult)
    {
        $this->model = $examResult;
    }

    public function check($input, $id)
    {
        $user = auth()->user();
        $exam = Exam::with('examQuestions.question.questionAnswers', 'examStatus')->find($id);
        try {
            DB::beginTransaction();
            $now = Carbon::now();
            $singles = $input['choice_single'];
            $multiples = $input['choice_multiple'];
            $texts = $input['text'];

            if (count($singles)) {
                foreach ($singles as $single) {
                    $dataUserQuestion[] = [
                        'user_id' => $user->id,
                        'exam_id' => $id,
                        'question_answer_id' => $single,
                        'created_at' => $now,
                    ];
                }
            }

            if (count($multiples)) {
                foreach ($multiples as $multiple) {
                    foreach ($multiple as $value) {
                        $dataUserQuestion[] = [
                            'user_id' => $user->id,
                            'exam_id' => $id,
                            'question_answer_id' => $value,
                            'created_at' => $now,
                        ];
                    }
                }
            }

            if (count($texts)) {
                foreach ($texts as $key => $text) {
                    $questionAnswerIds[] = QuestionAnswer::insertGetId([
                        'question_id' => $key,
                        'content' => $text,
                        'correct' => config('common.question_answer.correct.answer_false'),
                    ]);
                }

                foreach ($questionAnswerIds as $questionAnswerId) {
                    $dataUserQuestion[] = [
                        'user_id' => $user->id,
                        'exam_id' => $id,
                        'question_answer_id' => $questionAnswerId,
                        'created_at' => $now,
                    ];
                }
            }

            UserQuestion::where([
                'user_id' => $user->id,
                'exam_id' => $id,
            ])->delete();
            UserQuestion::insert($dataUserQuestion);

            /*score*/
            $score = config('common.exam.score_default');
            $examQuestions = $exam->examQuestions;
            $inputMultiples =  array_get($input, 'choice_multiple');
            $inputSingles =  array_get($input, 'choice_single');
            if (!(is_null($inputSingles) && is_null($inputMultiples))) {
                foreach ($examQuestions as $examQuestion) {
                    $questionAnswerTrues = null;
                    $type = $examQuestion->question->type;
                    $questionId = $examQuestion->question->id;
                    if ($type == config('common.question.type_question.single_choice')) {
                        $userQuestions = $inputSingles[$questionId];
                        $questionAnswers = $examQuestion->question->questionAnswers;
                        foreach ($questionAnswers as $questionAnswer) {
                            if ($questionAnswer->correct == config('common.question_answer.correct.answer_true')
                                && $userQuestions == $questionAnswer->id) {
                                $score++;
                                break;
                            }
                        }
                    }
                    elseif ($type == config('common.question.type_question.multiple_choice')) {
                        $questionAnswers = $examQuestion->question->questionAnswers;

                        foreach ($questionAnswers as $questionAnswer) {
                            if ($questionAnswer->correct == config('common.question_answer.correct.answer_true')) {
                                $questionAnswerTrues[] =  $questionAnswer->id;
                            }
                        }

                        $userQuestions = $inputMultiples[$questionId];

                        if (count($questionAnswerTrues) == count($userQuestions)) {
                            for ($index = 0; $index < count($questionAnswerTrues); $index++) {
                                if (!in_array($questionAnswerTrues[$index], $userQuestions)) {
                                    //false
                                    break;
                                } elseif ($index == count($questionAnswerTrues) - 1) {
                                    //true
                                    $score++;
                                }
                            }
                        }
                    }
                }
            }
            ExamResult::where([
                'user_id' => $user->id,
                'exam_id' => $id,
            ])->delete();
            ExamResult::firstOrCreate([
                'user_id' => $user->id,
                'exam_id' => $id,
                'result' => $score,
                'time_spent' => $input['time_spent']
            ]);

            $exam->examStatus->update(['status' => config('common.exam.status.exam_unchecked')]);
            DB::commit();
            $message = trans('messages.success.finish_exam_success');
        } catch (Exception $ex) {
            DB::rollBack();
            $message = trans('messages.error.finish_exam_error');
        }

        return $message;
    }

    public function save($input, $id)
    {
        $user = auth()->user();
        $exam = Exam::with('examQuestions.question.questionAnswers', 'examStatus')->find($id);
        try {
            DB::beginTransaction();
            $now = Carbon::now();
            $singles = $input['choice_single'];
            $multiples = $input['choice_multiple'];
            $texts = $input['text'];

            if (count($singles)) {
                foreach ($singles as $single) {
                    $dataUserQuestion[] = [
                        'user_id' => $user->id,
                        'exam_id' => $id,
                        'question_answer_id' => $single,
                        'created_at' => $now,
                    ];
                }
            }

            if (count($multiples)) {
                foreach ($multiples as $multiple) {
                    foreach ($multiple as $value) {
                        $dataUserQuestion[] = [
                            'user_id' => $user->id,
                            'exam_id' => $id,
                            'question_answer_id' => $value,
                            'created_at' => $now,
                        ];
                    }
                }
            }

            if (count($texts)) {
                foreach ($texts as $key => $text) {
                    $questionAnswerIds[] = QuestionAnswer::insertGetId([
                        'question_id' => $key,
                        'content' => $text,
                        'correct' => config('common.question_answer.correct.answer_false'),
                    ]);
                }

                foreach ($questionAnswerIds as $questionAnswerId) {
                    $dataUserQuestion[] = [
                        'user_id' => $user->id,
                        'exam_id' => $id,
                        'question_answer_id' => $questionAnswerId,
                        'created_at' => $now,
                    ];
                }
            }

            UserQuestion::where([
                'user_id' => $user->id,
                'exam_id' => $id,
            ])->delete();
            UserQuestion::insert($dataUserQuestion);
            ExamResult::where([
                'user_id' => $user->id,
                'exam_id' => $id,
            ])->delete();
            ExamResult::firstOrCreate([
                'user_id' => $user->id,
                'exam_id' => $id,
                'result' => config('common.exam.score_default'),
                'time_spent' => $input['time_spent']
            ]);
            $exam->examStatus->update(['status' => config('common.exam.status.exam_save')]);
            DB::commit();
            $message = trans('messages.success.save_exam_success');
        } catch (Exception $ex) {
            DB::rollBack();
            $message = trans('messages.error.save_exam_error');
        }

        return $message;
    }

}
