<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\QueryFilter;

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

    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

}
