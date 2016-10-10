<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Repositories\Suggestion\SuggestionRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Client\SuggestionRequest;
use App\Http\Requests\Client\SuggestionEditRequest;
use App\Http\Requests;

class SuggestionController extends Controller
{
    protected $suggestionRepository;

    public function __construct(SuggestionRepositoryInterface $suggestionRepository)
    {
        $this->suggestionRepository = $suggestionRepository;
        parent::__construct(config('common.menu.menu_suggestion'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $suggestions = $this->suggestionRepository->index($user->id);
        return view('users.suggestions.index', compact('suggestions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataRtn = $this->suggestionRepository->userCreate();
        $subjects = $dataRtn['subjects'];
        $types = $dataRtn['types'];
        $data = $dataRtn['data'];
        return view('users.suggestions.create', compact('subjects', 'types', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SuggestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuggestionRequest $request)
    {
        $input = $request->only('subject_id', 'type', 'content',
            'content_text',
            'content_single_choice', 'correct_single_choice',
            'content_multiple_choice', 'correct_multiple_choice');
        $message = $this->suggestionRepository->store($input);

        return redirect()->route('suggestion.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataRtn = $this->suggestionRepository->edit($id);
        $suggestion = $dataRtn['suggestion'];
        return view('users.suggestions.show', compact('suggestion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataRtn = $this->suggestionRepository->edit($id);
        $subjects = $dataRtn['subjects'];
        $types = $dataRtn['types'];
        $data = $dataRtn['data'];
        $suggestion = $dataRtn['suggestion'];
        $type = $dataRtn['type'];
        $suggestionDetail = json_encode([
            'view' => view('layout.suggestion-detail', [
                'suggestion' => $suggestion,
                'type' => $type,
            ])->render(),
        ]);
        return view('users.suggestions.edit', compact('subjects', 'types', 'data', 'suggestion', 'type', 'suggestionDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SuggestionEditRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SuggestionEditRequest $request, $id)
    {
        $input = $request->only('subject_id', 'type', 'content', 'content_option', 'correct_option',
        'content_text',
            'content_single_choice', 'correct_single_choice',
            'content_multiple_choice', 'correct_multiple_choice', 'remove');
        $message = $this->suggestionRepository->update($input, $id);

        return redirect()->route('suggestion.index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->suggestionRepository->delete($id);
        return redirect()->route('suggestion.index')->with('message', $message);
    }
}
