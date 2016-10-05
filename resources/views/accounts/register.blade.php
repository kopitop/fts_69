@extends('accounts.master')
@section('title')
    {{ trans('accounts/registers/names.title') }}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-info-sign"></span> {{ trans('accounts/registers/names.panel_heading') }}</div>
                    <div class="panel-body">
                        @include('layout.error')
                        @include('layout.message')
                        {{ Form::open(['route' => 'register.store', 'method' => 'POST', 'class' => 'form-horizontal']) }}
                            <div class="form-group">
                                <label for="{{ trans('names.label.label_for', ['label_for' => 'name']) }}" class="col-sm-4 control-label">
                                    {{ trans('accounts/registers/names.label_form.name') }}</label>
                                <div class="col-sm-8">
                                    <input name="name" type="text" class="form-control" id="{{ trans('names.label.label_for', ['label_for' => 'name']) }}"
                                        placeholder="{{ trans('accounts/registers/names.placeholder.name_user') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="{{ trans('names.label.label_for', ['label_for' => 'email']) }}" class="col-sm-4 control-label">
                                    {{ trans('accounts/registers/names.label_form.email') }}</label>
                                <div class="col-sm-8">
                                    <input name="email" type="email" class="form-control" id="{{ trans('names.label.label_for', ['label_for' => 'email']) }}"
                                           placeholder="{{ trans('accounts/registers/names.placeholder.email_user') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="{{ trans('names.label.label_for', ['label_for' => 'chatwork']) }}" class="col-sm-4 control-label">
                                    {{ trans('accounts/registers/names.label_form.chatwork_id') }}</label>
                                <div class="col-sm-8">
                                    <input name="chatwork_id" type="text" class="form-control" id="{{ trans('names.label.label_for', ['label_for' => 'chatwork']) }}"
                                           placeholder="{{ trans('accounts/registers/names.placeholder.chatwork_id') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="{{ trans('names.label.label_for', ['label_for' => 'password']) }}" class="col-sm-4 control-label">
                                    {{ trans('accounts/registers/names.label_form.password') }}</label>
                                <div class="col-sm-8">
                                    <input name="password" type="password" class="form-control" id="{{ trans('names.label.label_for', ['label_for' => 'password']) }}"
                                           placeholder="{{ trans('accounts/registers/names.placeholder.password_user') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="{{ trans('names.label.label_for', ['label_for' => 'password-confirm']) }}" class="col-sm-4 control-label">
                                    {{ trans('accounts/registers/names.label_form.password_confirmation') }}</label>
                                <div class="col-sm-8">
                                    <input name="password_confirmation" type="password" class="form-control" id="{{ trans('names.label.label_for', ['label_for' => 'password-confirm']) }}"
                                           placeholder="{{ trans('accounts/registers/names.placeholder.password_confirmation_user') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="{{ trans('names.label.label_for', ['label_for' => 'avatar']) }}" class="col-sm-4 control-label">
                                    {{ trans('accounts/registers/names.label_form.avatar') }}</label>
                                <div class="col-sm-8">
                                    <input name="avatar" type="file" class="form-control" id="{{ trans('names.label.label_for', ['label_for' => 'avatar']) }}">
                                </div>
                            </div>
                            <div class="form-group last">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        {{ trans('names.button.button_register') }}
                                    </button>
                                    <button type="reset" class="btn btn-default btn-sm">
                                        {{ trans('names.button.button_reset') }}
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

