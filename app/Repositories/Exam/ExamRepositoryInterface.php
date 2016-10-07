<?php

namespace App\Repositories\Exam;

interface ExamRepositoryInterFace
{
    public function examIndex();
    public function createExam($subjectId);
    public function startExam($examId);
}
