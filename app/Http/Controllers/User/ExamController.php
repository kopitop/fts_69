<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        $data = $this->examRepository->examIndex();
        $exams = $data['exams'];
        $subjects = $data['subjects'];

        return view('users.exams.index', compact('exams', 'subjects'));
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
        $subjectId = $request->subject_id;
        $message = $this->examRepository->createExam($subjectId);

        return redirect()->route('exam.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->examRepository->startExam($id);
        $exam = $data['exam'];
        $duration = $data['duration'];

        return view('users.exams.show', compact('exam', 'duration'));
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

        return view('users.exams.edit', compact('exam', 'answer'));
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
