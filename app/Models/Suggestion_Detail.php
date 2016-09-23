<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuggestionDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'suggestion_id', 'option', 'correct',
    ];

    public function suggestion()
    {
        return $this->belongsTo(Suggestion::class);
    }

}
