<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

}
