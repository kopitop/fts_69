<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Account\LoginRequest;
use App\Http\Requests;
use Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accounts.login');
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
     * @param  LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $input = $request->only('email', 'password', 'remember_me');

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']], $input['remember_me'])) {
            $message = trans('messages.success.login_success');

            if (auth()->user()->role == config('roles.admin')) {
                return redirect()->route('admin.user.index')->with('message', $message);
            }

            return redirect()->route('home.index')->with('message', $message);
        }

        $message = trans('messages.error.login_fail');
        return redirect()->route('login.index')->with('message', $message);
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
