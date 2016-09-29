<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserEditRequest;
use App\Filter\UserFilters;
use App\Models\User;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct(config('common.menu.menu_user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserFilters $filters)
    {
        $record = config('common.user.user_record_default');
        $searchTypes = [
            'name' => trans('admins/users/names.label_form.label_name_user'),
            'email' => trans('admins/users/names.label_form.label_email_user'),
            'chatworkId' => trans('admins/users/names.label_form.label_chatwork_id'),
        ];
        $input = $filters->input();
        foreach ($input as $key => $value) {
            $searchType = $key;
            $searchText = $value;
        }

        $route = "admin.user.index";
        $users =  User::filter($filters)->paginate($record);
        return view('admins.users.list', compact('users', 'searchType', 'searchText', 'searchTypes', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $input = $request->only('name', 'email', 'avatar', 'chatwork_id', 'password');
        $input['role'] = config('roles.user');

        if ($request->hasFile('avatar')) {
            $input['avatar'] = $this->userRepository->upload($input['avatar']);
        } else {
            $input['avatar'] = config('common.user.avatar_name_default');
        }

        $message = $this->userRepository->create($input);
        return redirect()->route('admin.user.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->show($id);
        return view('admins.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->show($id);
        return view('admins.users.edit', compact('user'));
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
        return redirect()->route('admin.user.index')->with('message', $message);
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
        return redirect()->route('admin.user.index')->with('message', $message);
    }
}
