@extends('accounts.master')
@section('title')
    {{ trans('accounts/forgot_passwords/names.title') }}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-lock"></span> {{ trans('accounts/forgot_passwords/names.panel_heading') }}</div>
                    <div class="panel-body">
                        @include('layout.error')
                        @include('layout.message')
                        {{ Form::open(['route' => 'forgot-password.store', 'method' => 'POST', 'class' => 'form-horizontal']) }}
                            <div class="form-group">
                                <label for="{{ trans('names.label.label_for', ['label_for' => 'email']) }}" class="col-sm-4 control-label">
                                    {{ trans('accounts/forgot_passwords/names.label_form.email') }}
                                </label>
                                <div class="col-sm-8">
                                    <input name="email" type="email" class="form-control" id="{{ trans('names.label.label_for', ['label_for' => 'email']) }}"
                                           placeholder="{{ trans('accounts/forgot_passwords/names.placeholder.email_user') }}" required>
                                </div>
                            </div>
                            <div class="form-group last">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        {{ trans('names.button.button_submit') }}
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

