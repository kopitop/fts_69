<?php

namespace App\Http\Controllers\Admin;

use App\Filter\ExamFilters;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Repositories\Exam\ExamRepositoryInterFace;
use Illuminate\Http\Request;

use App\Http\Requests;

class ExamController extends Controller
{
    protected $examRepository;

    public function __construct(ExamRepositoryInterFace $examRepository)
    {
        $this->examRepository = $examRepository;
        parent::__construct(config('common.menu.menu_exam'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExamFilters $filters)
    {
        $record = config('common.exam.exam_record_default');
        $sort = config('common.sort.descending');
        $searchTypes = [
            'name' => trans('admins/exams/names.label_form.name_exam'),
            'subject' => trans('admins/exams/names.label_form.subject_exam'),
            'result' => trans('admins/exams/names.label_form.result_exam'),
            'user' => trans('admins/exams/names.label_form.user_name'),
            'status' => trans('admins/exams/names.label_form.status_exam'),
        ];
        $input = $filters->input();

        foreach ($input as $key => $value) {
            $searchType = $key;
            $searchText = $value;
        }

        $route = "admin.exam.index";
        $exams =  Exam::with('examQuestions', 'examStatus.user', 'examResult.user', 'subject')
            ->filter($filters)->orderBy('exams.created_at', $sort)->paginate($record);

        return view('admins.exams.index', compact('exams', 'searchTypes', 'searchType', 'searchText', 'route'));
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
        $data = $this->examRepository->show($id);
        $exam = $data['exam'];
        $answer = $data['answer'];
        return view('admins.exams.show', compact('exam', 'answer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->examRepository->show($id);
        $exam = $data['exam'];
        $answer = $data['answer'];
        return view('admins.exams.edit', compact('exam', 'answer'));
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
        $input = $request->only('user_id');
        $this->examRepository->update($input, $id);
        $message = trans('messages.success.update_success', ['item' => 'exam']);
        return redirect()->route('admin.exam.index')->with('message', $message);
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
