@extends('admins.master')
@section('title')
    {{ trans('admins/users/names.title_user_page') }}
@endsection
@section('heading')
    {{ trans('admins/users/names.heading_user_page') }}
@endsection
@section('action')
    {{ trans('admins/users/names.action.detail_user') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/users/names.panel.panel_head_detail') }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <div class="row">
                <div class="col-lg-1">
                    <img src="{{ asset(($user->avatar == config('common.user.avatar_name_default'))
                    ? config('common.path_image_system') . config('common.user.avatar_name_default')
                    : config('common.user.avatar_url') . $user->avatar) }}" class="avatar">
                </div>
                <div class="col-lg-9">
                    <ul>
                        <li>
                            {{ trans('admins/users/names.label_form.label_name_user') }} - {{ $user->name }}
                        </li>
                        <li>
                            {{ trans('admins/users/names.label_form.label_chatwork_id') }} - {{ $user->chatwork_id }}
                        </li>
                        <li>
                            {{ trans('admins/users/names.label_form.label_email_user') }} - {{ $user->email }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{
                Form::open([
                    'route' => ['admin.user.destroy', $user->id],
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'user']) . '")'
                ])
            }}
                <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-warning">{{ trans('names.button.button_edit') }}</a>
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">{{ trans('names.button.button_back') }}</a>
                {{ Form::button(trans('names.button.button_delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    </div>
    <!-- /.box -->
@endsection
