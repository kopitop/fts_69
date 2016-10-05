@extends('accounts.master')
@section('title')
    {{ trans('accounts/logins/names.title') }}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-lock"></span> {{ trans('accounts/logins/names.panel_heading') }}</div>
                    <div class="panel-body">
                        @include('layout.error')
                        @include('layout.message')
                        {{ Form::open(['route' => 'login.store', 'method' => 'POST', 'class' => 'form-horizontal']) }}
                            <div class="form-group">
                                <label for="email" class="col-sm-4 control-label">
                                    {{ trans('accounts/logins/names.label_form.email') . trans('names.label.label_require') }}
                                </label>
                                <div class="col-sm-8">
                                    <input name="email" type="email" class="form-control" id="email"
                                           placeholder="{{ trans('accounts/logins/names.place_holder.email_user') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">
                                    {{ trans('accounts/logins/names.label_form.password') . trans('names.label.label_require') }}</label>
                                <div class="col-sm-8">
                                    <input name="password" type="password" class="form-control" id="password"
                                           placeholder="{{ trans('accounts/logins/names.place_holder.password_user') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember_me"/>
                                            {{ trans('accounts/logins/names.label_form.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group last">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        {{ trans('names.button.button_login') }}
                                    </button>
                                    <button type="reset" class="btn btn-default btn-sm">
                                        {{ trans('names.button.button_reset') }}
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                    <div class="panel-footer">
                        <a href="#"><i class="fa fa-registered"></i> {{ trans('accounts/logins/names.label_form.register') }}</a>
                        <a href="#" class="forgot-password">
                            <i class="fa fa-refresh"></i> {{ trans('accounts/logins/names.label_form.forgot_password') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

