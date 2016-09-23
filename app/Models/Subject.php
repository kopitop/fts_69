<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'duration', 'number_question',
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
