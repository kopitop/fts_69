<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'subject_id', 'type', 'content',
    ];

    public function questionAnswers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
