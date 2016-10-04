<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suggestion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'subject_id', 'content', 'type', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suggestionDetails()
    {
        return $this->hasMany(SuggestionDetail::class);
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function getStatusAttribute($value)
    {
        $config = config('common.suggestion.status');
        $trans = trans('admins/suggestions/names.label_form.status');
        return ($value == $config['confirm']) ? $trans['confirm'] : $trans['waiting'];
    }

    public function getTypeAttribute($value)
    {
        $config = config('common.question.type_question');
        $trans = trans('admins/questions/names.label_form');
        $dataRtn = $trans['single_choice'];

        switch ($value) {
            case $config['multiple_choice']:
                $dataRtn = $trans['multiple_choice'];
                break;
            case $config['text']:
                $dataRtn = $trans['text'];
                break;
        }

        return $dataRtn;
    }

}
