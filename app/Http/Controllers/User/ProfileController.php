<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Requests;

class ProfileController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct(config('common.menu.menu_profile'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
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
     * @param  UserEditRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, $id)
    {
        $user = $this->userRepository->find($id);
        $input = $request->only('name', 'email', 'chatwork_id');

        if ($request->hasFile('avatar_new')) {
            $newAvatar = $request->avatar_new;
            $oldFile = public_path() . config('common.user.avatar_url') . $user->avatar;
            $input['avatar'] = $this->userRepository->updateAvatar($oldFile, $newAvatar);
        }

        $this->userRepository->update($input, $id);
        $message = trans('messages.success.update_success', ['item' => 'user']);
        return redirect()->route('profile.index')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);
        $message = $this->userRepository->destroy($user);
        return redirect()->route('login.index')->with('message', $message);
    }
}
