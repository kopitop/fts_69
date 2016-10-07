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
        $exams = Exam::with('subject', 'examStatus', 'examResult')->orderBy('created_at', $sort)->get();
        $subjects = Subject::orderBy('created_at', $sort)->pluck('name', 'id');
        $data = [
            'exams' => $exams,
            'subjects' => $subjects,
        ];

        return $data;
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
            dd($ex);
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

}
