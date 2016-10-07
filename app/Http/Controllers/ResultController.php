<?php

namespace App\Http\Controllers;

use App\Repositories\Result\ResultRepositoryInterFace;
use Illuminate\Http\Request;

use App\Http\Requests;

class ResultController extends Controller
{
    protected $resultRepository;

    public function __construct(ResultRepositoryInterFace $resultRepository)
    {
        $this->resultRepository = $resultRepository;
        parent::__construct(config('common.menu.menu_exam'));
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
        $input = $request->only('choice_single', 'choice_multiple', 'text', 'time_spent', 'btn_exam');

        if ($input['btn_exam'] == "save") {
            $message = $this->resultRepository->save($input, $id);
        } else {
            $message = $this->resultRepository->check($input, $id);
        }

        return redirect()->route('exam.index')->with('message', $message);
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
