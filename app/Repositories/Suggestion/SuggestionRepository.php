<?php

namespace App\Repositories\Suggestion;

use App\Models\Suggestion;
use App\Repositories\BaseRepository;

class SuggestionRepository extends BaseRepository implements SuggestionRepositoryInterface
{
    public function __construct(Suggestion $suggestion)
    {
        $this->model = $suggestion;
    }

    public function show($id = null)
    {
        return Suggestion::with('user', 'subject', 'suggestionDetails')->find($id);
    }

    public function confirm($id)
    {
        //
    }
}
