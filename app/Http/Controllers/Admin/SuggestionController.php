<?php

namespace App\Http\Controllers\Admin;

use App\Filter\SuggestionsFilters;
use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use App\Repositories\Suggestion\SuggestionRepository;
use Illuminate\Http\Request;
use App\Http\Requests;

class SuggestionController extends Controller
{

    private $suggestionRepository;

    public function __construct(SuggestionRepository $suggestionRepository)
    {
        parent::__construct(config('common.menu.menu_suggestion'));
        $this->suggestionRepository = $suggestionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SuggestionsFilters $filters)
    {
        $record = config('common.suggestion.suggestion_record_default');
        $sort = config('common.sort.descending');
        $searchTypes = [
            'user' => trans('admins/suggestions/names.label_form.user_name'),
            'subject' => trans('admins/suggestions/names.label_form.subject_name'),
            'content' => trans('admins/suggestions/names.label_form.content'),
            'status' => trans('admins/suggestions/names.label_form.status.name'),
            'type' => trans('admins/suggestions/names.label_form.type'),
        ];
        $input = $filters->input();

        foreach ($input as $key => $value) {
            $searchType = $key;
            $searchText = $value;
        }

        $route = "admin.suggestion.index";
        $suggestions =  Suggestion::filter($filters)->orderBy('suggestions.created_at', $sort)->paginate($record);
        return view('admins.suggestions.index', compact('suggestions', 'searchTypes', 'searchType', 'searchText', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $suggestion = $this->suggestionRepository->show($id);
        return view('admins.suggestions.show', compact('suggestion'));
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
