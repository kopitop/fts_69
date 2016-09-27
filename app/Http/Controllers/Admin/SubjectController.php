<?php

namespace App\Http\Controllers\Admin;

use App\Filter\SubjectFilters;
use App\Models\Subject;
use App\Repositories\Subject\SubjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Admin\SubjectRequest;

class SubjectController extends Controller
{
    private $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubjectFilters $filters)
    {
        $record = config('common.subject.subject_record_default');
        $sort = config('common.sort.descending');
        $searchTypes = [
            'name' => trans('admins/subjects/names.label_form.name_subject'),
            'duration' => trans('admins/subjects/names.label_form.duration_subject'),
            'numberQuestion' => trans('admins/subjects/names.label_form.question_number_subject'),
        ];
        $input = $filters->input();

        foreach ($input as $key => $value) {
            $searchType = $key;
            $searchText = $value;
        }

        $subjects =  Subject::filter($filters)->orderBy('created_at', $sort)->paginate($record);
        return view('admins.subjects.index', compact('subjects', 'searchTypes', 'searchType', 'searchText'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SubjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        $input = $request->only('name', 'duration', 'number_question');
        $message = $this->subjectRepository->create($input);
        return redirect()->route('admin.subject.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = $this->subjectRepository->show($id);
        return view('admins.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = $this->subjectRepository->show($id);
        return view('admins.subjects.edit', compact('subject'));
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
        $input = $request->only('name', 'duration', 'number_question');
        $this->subjectRepository->update($input, $id);
        $message = trans('messages.success.update_success', ['item' => 'subject']);
        return redirect()->route('admin.subject.index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->subjectRepository->delete($id);
        return redirect()->route('admin.subject.index')->with('message', $message);
    }
}
