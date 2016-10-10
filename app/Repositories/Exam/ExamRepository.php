<?php

namespace App\Repositories\Exam;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamStatus;
use App\Models\Question;
use App\Models\Subject;
use App\Models\QuestionAnswer;
use App\Models\UserQuestion;
use Exception;
use DB;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class ExamRepository extends BaseRepository implements ExamRepositoryInterFace
{
    public function __construct(Exam $exam)
    {
        $this->model = $exam;
    }

    public function examIndex()
    {
        $sort = config('common.sort.descending');
        $user = auth()->user();
        $examId = ExamStatus::where('user_id', $user->id)->pluck('exam_id');
        $exams = Exam::with('subject', 'examStatus', 'examResult')->orderBy('created_at', $sort)->whereIn('id', $examId)->get();
        $subjects = Subject::orderBy('created_at', $sort)->pluck('name', 'id');

        return compact('exams', 'subjects');
    }

    public function createExam($subjectId)
    {
        $user = auth()->user();
        $subject = Subject::findOrFail($subjectId);
        $numberExamOfSubject = Exam::where('subject_id', $subjectId)->count();
        $questionOfSubjects = Question::where('subject_id', $subjectId)->get();
        $numberQuestion = (int)$subject->number_question;

        if ($questionOfSubjects->count() < $numberQuestion) {
            return trans('messages.error.create_exam_fail');
        }

        try {
            DB::beginTransaction();
            $exam = Exam::firstOrCreate([
                'subject_id' => $subjectId,
                'name' => trans('users/exams/names.label.name_exam', [
                    'subjectName' => $subject->name,
                    'examNumber' => $numberExamOfSubject + 1,
                ]),
            ]);

            ExamStatus::firstOrCreate([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'status' => config('common.exam.status.exam_testing'),
            ]);

            for ($index = 0; $index < $numberQuestion; $index++) {
                $dataExamQuestion[] = [
                    'exam_id' => $exam->id,
                    'question_id' => array_rand($questionOfSubjects->pluck('id')->toArray()),
                ];
            }

            ExamQuestion::insert($dataExamQuestion);
            DB::commit();
            $message = trans('messages.success.create_success', ['item' => 'exam']);
        } catch (Exception $ex) {
            DB::rollBack();
            $message = trans('messages.error.create_exam_fail');
        }

        return $message;
    }

    public function startExam($examId)
    {
        $exam = Exam::with('examQuestions.question.questionAnswers', 'examResult')->find($examId);
        if (count($exam->examResult)) {
            $data = [
                'exam' => $exam,
                'duration' => $exam->examResult->time_spent,
            ];
        } else {
            $subject = Subject::find($exam->subject_id);
            $data = [
                'exam' => $exam,
                'duration' => "$subject->duration:00",
            ];
        }

        return $data;
    }

    public function show($id = null)
    {
        $exam = Exam::with('userQuestions', 'examQuestions.question.questionAnswers', 'examStatus.user', 'examResult.user', 'subject')
            ->find($id);

        $userQuestions = $exam->userQuestions->pluck('question_answer_id')->toArray();
        if (count($exam->examQuestions)) {
            foreach ($exam->examQuestions as $examQuestion) {
                $question = $examQuestion->question;
                if ($question->type == config('common.question.type_question.single_choice')) {
                    $index = 0;
                    foreach ($question->questionAnswers as $questionAnswer) {
                        $index++;
                        if (in_array($questionAnswer->id, $userQuestions)
                            && $questionAnswer->correct == config('common.question_answer.correct.answer_true')) {
                            $answerInfor[] = [$question->id => trans('admins/exams/names.label_form.exam_correct')];
                            break;
                        } else {
                            if ($index == count($question->questionAnswers)) {
                                $answerInfor[] = [$question->id => trans('admins/exams/names.label_form.exam_incorrect')];
                            } else {
                                continue;
                            }
                        }
                    }
                } elseif ($question->type == config('common.question.type_question.multiple_choice')) {
                    $dataUserQuestion = null;
                    $correctTrue = null;
                    foreach ($question->questionAnswers as $questionAnswer) {
                        if (in_array($questionAnswer->id, $userQuestions)) {
                            $dataUserQuestion[] = $questionAnswer->id;
                        }
                    }

                    $correctTrue = [];
                    foreach ($question->questionAnswers as $questionAnswer) {
                        if ($questionAnswer->correct == config('common.question_answer.correct.answer_true')) {
                            $correctTrue[] = ['id' => $questionAnswer->id];
                        }
                    }

                    $correctTrue = array_pluck($correctTrue, 'id');
                    if (count($dataUserQuestion) != count($correctTrue)) {
                        $answerInfor[] = [$question->id => trans('admins/exams/names.label_form.exam_incorrect')];
                    } else {
                        for ($index = 0; $index < count($correctTrue); $index++) {
                            if (!in_array($correctTrue[$index], $userQuestions)) {
                                $answerInfor[] = [$question->id => trans('admins/exams/names.label_form.exam_incorrect')];
                                break;
                            } else {
                                if ($index == count($correctTrue) - 1) {
                                    $answerInfor[] = [$question->id => trans('admins/exams/names.label_form.exam_correct')];
                                } else {
                                    continue;
                                }
                            }
                        }
                    }
                } else {
                    foreach ($question->questionAnswers as $questionAnswer) {
                        if ($exam->userQuestions->pluck('question_answer_id')->contains($questionAnswer->id)) {
                            if ($questionAnswer->correct == config('common.question_answer.correct.answer_false')) {
                                $answerInfor[] = [$question->id => trans('admins/exams/names.label_form.exam_incorrect')];
                            } else {
                                $answerInfor[] = [$question->id => trans('admins/exams/names.label_form.exam_correct')];
                            }
                        }
                    }
                }
            }
        }
        $dataReturn = [
            'exam' => $exam,
            'answer' => $answerInfor,
        ];

        return $dataReturn;
    }

    public function update($inputs, $id)
    {
        $exam = Exam::with('subject', 'examResult.user')->find($id);
        ExamStatus::where([
            'exam_id' => $exam->id,
            'user_id' => $inputs['user_id'],
        ])->update(['status' => config('common.exam.status.exam_checked')]);

        /*send email*/
        $email = $exam->examResult->user->email;
        try {
            Mail::send('layout.mail-exam', [
                'subject' => $exam->subject->name,
                'user' => $exam->examResult->user->name,
                'exam' => $exam->name,
                'result' => $exam->examResult->result . "/" . $exam->subject->number_question,
                'start' => $exam->created_at,
            ], function ($message) use($email, $exam) {
                $message->to($email)->subject(trans('admins/exams/names.system.subject_mail_exam', ['subject' => $exam->subject->name]));
            });
            $messageEmail = trans('messages.success.send_mail_result_exam_success');
        } catch (Exception $ex) {
            $messageEmail = trans('messages.error.send_mail_result_exam_error');
        }

        /*send chatwork*/
        $chatworkId = $exam->examResult->user->chatwork_id;
        $view = view('layout.chatwork', [
            'subject' => $exam->subject->name,
            'user' => $exam->examResult->user->name,
            'exam' => strip_tags($exam->name),
            'result' => $exam->examResult->result . "/" . $exam->subject->number_question,
            'start' => $exam->created_at,
        ])->render();
        $apiKey = config('common.api_chatwork');
        ChatworkSDK::setApiKey($apiKey);
        $api = new ChatworkApi();

        /*get all contacts*/
        $contacts = $api->getContacts();
        $member = null;

        foreach ($contacts as $contact) {
            if ($contact["chatwork_id"] == $chatworkId) {
                $member = $contact;
            }
        }

        if (count($member)) {
            $api->createRoomMessage($member["room_id"], $view);
            $messageChatwork = trans('messages.success.send_message_chatwork_success');
        } else {
            $messageChatwork = trans('messages.error.send_message_chatwork_error');
        }

        return [
            'messageEmail' => $messageEmail,
            'messageChatwork' => $messageChatwork,
        ];
    }

}
