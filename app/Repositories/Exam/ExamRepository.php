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

}
