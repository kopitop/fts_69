@extends('admins.master')
@section('title')
    {{ trans('users/profiles/name.title') }}
@endsection
@section('content')
    <div class="panel panel-primary" id="profile">
        <div class="panel-heading">
            <h1>{{ trans('users/profiles/name.heading') }}</h1>
        </div>
        <div class="panel-body">
            @include('layout.error')
            @include('layout.message')
            {{ Form::open(['route' => ['admin.profile.update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'name']), trans('users/profiles/name.label.name_user') . trans('names.label.label_require')) }}
                    {{ Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => trans('users/profiles/name.placeholder.name_user')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'email']), trans('users/profiles/name.label.email_user') . trans('names.label.label_require')) }}
                    {{ Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => trans('users/profiles/name.placeholder.email_user')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'chatwork']), trans('users/profiles/name.label.chatwork_id') . trans('names.label.label_require')) }}
                    {{ Form::text('chatwork_id', $user->chatwork_id, ['class' => 'form-control', 'placeholder' => trans('users/profiles/name.placeholder.chatwork_id_user')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'avatar']), trans('users/profiles/name.label.avatar_user')) }}
                    <img src="{{asset(config('common.user.path.avatar_url') . $user->avatar)}}" width="100px" height="100px">
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'avatar new']), trans('users/profiles/name.label.new_avatar_user')) }}
                    {{ Form::file('avatar_new') }}
                    <p class="help-block">{{ trans('users/profiles/name.label.help_block_avatar') }}</p>
                </div>
                {{ Form::button('<span class="glyphicon glyphicon-ok"></span> ' . trans('names.button.button_edit'), ['type' => 'submit', 'class' => 'btn btn-success']) }}
                <a href="{{ route('home.index') }}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-arrow-left"></span> {{ trans('names.button.button_back') }}
                </a>
            {{ Form::close() }}
            <i>{{ trans('users/profiles/name.label.confirm_change_password') }}</i>
            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#changePassword">
                <span class="glyphicon glyphicon-refresh"></span> {{ trans('users/profiles/name.label.password') }}
            </button>

            <!-- Modal change password -->
            <div id="changePassword" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ trans('users/profiles/name.label.password') }}</h4>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(['route' => 'admin.password.store', 'method' => 'POST']) }}
                                <div class="form-group">
                                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'password']), trans('users/profiles/name.label.old_password') . trans('names.label.label_require')) }}
                                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('users/profiles/name.placeholder.old_password')]) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'password-new']), trans('users/profiles/name.label.new_password') . trans('names.label.label_require')) }}
                                    {{ Form::password('password_new', ['class' => 'form-control', 'placeholder' => trans('users/profiles/name.placeholder.new_password')]) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'password-new-confirm']), trans('users/profiles/name.label.confirm_password') . trans('names.label.label_require')) }}
                                    {{ Form::password('password_new_confirmation', ['class' => 'form-control', 'placeholder' => trans('users/profiles/name.placeholder.confirm_password')]) }}
                                </div>
                                {{ Form::button('<span class="glyphicon glyphicon-ok"></span> ' . trans('names.button.button_edit'), ['type' => 'submit', 'class' => 'btn btn-success']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
