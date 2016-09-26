<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamResult extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'exam_id', 'user_id', 'result', 'time_spent',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
