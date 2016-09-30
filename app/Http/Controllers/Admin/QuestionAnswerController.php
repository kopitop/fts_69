<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Repositories\Question_Answer\QuestionAnswerRepositoryInterFace;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\QuestionAnswerRequest;
use App\Http\Requests;
use DB;
use App\Filter\QuestionAnswerFilters;
use App\Http\Requests\Admin\QuestionAnswerEditRequest;

class QuestionAnswerController extends Controller
{
    protected $questionAnswerRepository;

    public function __construct(QuestionAnswerRepositoryInterFace $questionAnswerRepository)
    {
        $this->questionAnswerRepository = $questionAnswerRepository;
        parent::__construct(config('common.menu.menu_question_answer'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $message = json_encode([
            'single_choice' => config('common.question.type_question.single_choice'),
            'single_choice_text' => trans('admins/questions/names.label_form.single_choice'),
            'multiple_choice' => config('common.question.type_question.multiple_choice'),
            'multiple_choice_text' => trans('admins/questions/names.label_form.multiple_choice'),
            'text' => config('common.question.type_question.text'),
            'text_string' => trans('admins/questions/names.label_form.text'),
        ]);
        $option = view('layout.option-choice')->render();
        $optionText = view('layout.option-text')->render();
        $questions = $this->questionAnswerRepository->getData();
        return view('admins.question_answers.create', compact('questions', 'option', 'message', 'optionText'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestionAnswerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionAnswerRequest $request)
    {
        $input = $request->only('question_id', 'content', 'correct');
        $message = $this->questionAnswerRepository->store($input);
        return redirect()->route('admin.question-answer.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questionAnswer = $this->questionAnswerRepository->show($id);
        return view('admins.question_answers.show', compact('questionAnswer'));
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
     * @param  QuestionAnswerEditRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionAnswerEditRequest $request, $id)
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
