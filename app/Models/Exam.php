<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'subject_id', 'name',
    ];

    public function userQuestions()
    {
        return $this->hasMany(UserQuestion::class);
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function examStatuses()
    {
        return $this->hasMany(ExamStatus::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
