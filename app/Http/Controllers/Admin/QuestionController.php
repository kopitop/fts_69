<?php

namespace App\Http\Controllers\Admin;

use App\Filter\QuestionFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionRequest;
use App\Models\Question;
use App\Repositories\Question\QuestionRepositoryInterFace;
use Illuminate\Http\Request;

use App\Http\Requests;

class QuestionController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepositoryInterFace $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QuestionFilters $filters)
    {
        $record = config('common.question.question_record_default');
        $sort = config('common.sort.descending');
        $searchTypes = [
            'subject' => trans('admins/questions/names.label_form.subject_question'),
            'type' => trans('admins/questions/names.label_form.type_question'),
            'content' => trans('admins/questions/names.label_form.content_question'),
        ];
        $input = $filters->input();

        foreach ($input as $key => $value) {
            $searchType = $key;
            $searchText = $value;
        }

        $route = "admin.question.index";
        $questions = Question::with('subject')->filter($filters)->orderBy('questions.created_at', $sort)->paginate($record);
        return view('admins.questions.index', compact('questions', 'searchTypes', 'searchType', 'searchText', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->questionRepository->getData();
        $subjects= $data['subjects'];
        $types = $data['types'];
        return view('admins.questions.create', compact('subjects', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $input = $request->only('subject_id', 'type', 'content');
        $message = $this->questionRepository->create($input);
        return redirect()->route('admin.question.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->show($id);
        return view('admins.questions.show', compact('question', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->questionRepository->getData();
        $question = $this->questionRepository->show($id);
        return view('admins.questions.edit', compact('question', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuestionRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, $id)
    {
        $input = $request->only('subject_id', 'type', 'content');
        $this->questionRepository->update($input, $id);
        $message = trans('messages.success.update_success', ['item' => 'question']);
        return redirect()->route('admin.question.index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->questionRepository->delete($id);
        return redirect()->route('admin.question.index')->with('message', $message);
    }
}
