<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserQuestion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'exam_id', 'user_id', 'question_answer_id',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questionAnswer()
    {
        return $this->belongsTo(QuestionAnswer::class);
    }

}
