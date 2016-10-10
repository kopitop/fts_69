<?php

namespace App\Repositories\Suggestion;

interface SuggestionRepositoryInterface
{
    public function confirm($id);
    public function index($userId);
    public function userCreate();
    public function edit($userId);
    public function deleteSuggestionDetail($id);
}
