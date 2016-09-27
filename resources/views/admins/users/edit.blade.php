@extends('admins.master')
@section('title')
    {{ trans('admins/users/names.title_user_page') }}
@endsection
@section('heading')
    {{ trans('admins/users/names.heading_user_page') }}
@endsection
@section('action')
    {{ trans('admins/users/names.action.edit_user') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/users/names.panel.panel_head_edit') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            @include('layout.error')
            {{ Form::open(['route' => ['admin.user.update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'user']),
                    trans('admins/users/names.label_form.label_name_user') . trans('names.label.label_require')) }}
                    {{ Form::text('name', $user->name, ['class' => 'form-control',
                    'placeholder' => trans('admins/users/names.place_holder.place_holder_name_user')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'chatworkID']),
                    trans('admins/users/names.label_form.label_chatwork_id') . trans('names.label.label_require')) }}
                    {{ Form::text('chatwork_id', $user->chatwork_id, ['class' => 'form-control',
                    'placeholder' => trans('admins/users/names.place_holder.place_holder_chatwork_id_user')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'email']),
                    trans('admins/users/names.label_form.label_email_user') . trans('names.label.label_require')) }}
                    {{ Form::text('email', $user->email, ['class' => 'form-control',
                    'placeholder' => trans('admins/users/names.place_holder.place_holder_email_user')]) }}
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'avatar']),
                    trans('admins/users/names.label_form.label_avatar_user')) }}
                    <img src="{{ asset($user->avatar) }}" class="avatar">
                </div>
                <div class="form-group">
                    {{ Form::label(trans('names.label.label_for', ['label_for' => 'avatar_new']),
                    trans('admins/users/names.label_form.label_new_avatar_user')) }}
                    {{ Form::file('avatar_new') }}
                    <p class="help-block">{{ trans('admins/users/names.label_form.label_help_block_avatar') }}</p>
                </div>
                {{ Form::button(trans('names.button.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
            {{ Form::close() }}
            {{
                Form::open([
                    'route' => ['admin.user.destroy', $user->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'user']) . '")'
                ])
            }}
                <i>{{ trans('admins/names.label.label_delete', ['item' => 'user']) }}</i>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) }}
            {{ Form::close() }}
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection
