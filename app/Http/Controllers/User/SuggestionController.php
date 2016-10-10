<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Repositories\Suggestion\SuggestionRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Client\SuggestionRequest;
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
        $trans = trans('admins/questions/names.label_form');
        $config = config('common.question.type_question');
        $subjects = Subject::orderBy('created_at', config('common.sort.descending'))->pluck('name', 'id');
        $types = [
            $config['single_choice'] => $trans['single_choice'],
            $config['multiple_choice'] => $trans['multiple_choice'],
            $config['text'] => $trans['text'],
        ];
        $data = json_encode([
            'key' => [
                'single' => $config['single_choice'],
                'multiple' => $config['multiple_choice'],
                'text' => $config['text'],
            ],
            'view' => [
                'text' => view('layout.option-text')->render(),
                'multiple' => view('layout.option-multiple-choice')->render(),
                'single' => view('layout.option-single-choice')->render(),
            ],
            'oldInput' => session("_old_input"),
        ]);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
