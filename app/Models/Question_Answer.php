<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswer extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'question_id', 'correct', 'content',
    ];

    public function userQuestions()
    {
        return $this->hasMany(UserQuestion::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
