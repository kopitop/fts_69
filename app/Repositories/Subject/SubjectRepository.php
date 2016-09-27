<?php

namespace App\Repositories\Subject;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamStatus;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\Subject;
use App\Models\Suggestion;
use App\Models\SuggestionDetail;
use App\Models\UserQuestion;
use Auth;
use File;
use Exception;
use DB;
use App\Repositories\BaseRepository;

class SubjectRepository extends BaseRepository
{
    public function __construct(Subject $subject)
    {
        $this->model = $subject;
    }

    public function show($id = null)
    {
        $subject = Subject::with('exams', 'questions')->where('id', $id)->first();
        return $subject;
    }

    public function delete($ids)
    {
        $subject = Subject::findOrFail($ids);

        try {
            DB::beginTransaction();
            $condition = [
                'subject_id'=> $subject->id,
            ];
            $questionIds = Question::where($condition)->pluck('id');
            $examIds = Exam::where($condition)->pluck('id');
            $suggestionIds = Suggestion::where($condition)->pluck('id');

            /**
             * delete question answer
             */
            QuestionAnswer::whereIn('question_id', $questionIds)->delete();

            /**
             * delete exam question
             */
            QuestionAnswer::whereIn('exam_id', $examIds)->delete();

            /**
             * delete exam result
             */
            ExamResult::whereIn('exam_id', $examIds)->delete();

            /**
             * delete exam statuses
             */
            ExamStatus::whereIn('exam_id', $examIds)->delete();

            /**
             * delete user questions
             */
            UserQuestion::whereIn('exam_id', $examIds)->delete();

            /**
             * delete suggestion details
             */
            SuggestionDetail::whereIn('suggestion_id', $suggestionIds)->delete();

            /**
             * delete suggestions
             */
            $subject->suggestions()->delete();

            /**
             *  delete exams
             */
            $subject->exams()->delete();

            /**
             * delete questions
             */
            $subject->questions()->delete();

            /**
             * delete subjects
             */
            $subject->delete();
            DB::commit();
            $message = trans('messages.success.delete_success', ['item' => 'subject']);
        } catch (Exception $e) {
            DB::rollBack();
            $message = trans('messages.error.delete_error', ['item' => 'subject']);
        }

        return $message;
    }
}
