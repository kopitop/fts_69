<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Account\RegisterRequest;
use App\Http\Requests;

class RegisterController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accounts.register');
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
     * @param  RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $input = $request->only('name', 'email', 'avatar', 'chatwork_id', 'password');
        $input['role'] = config('roles.user');

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $this->userRepository->upload($input['avatar']);
        } else {
            $input['avatar'] = config('common.user.avatar_name_default');
        }

        $message = $this->userRepository->create($input);
        if ($message == $message = trans('messages.success.create_success', ['item' => 'user'])) {
            return redirect()->route('login.index')->with('message', $message);
        } else {
            return redirect()->route('register.index')->with('message', $message);
        }

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
