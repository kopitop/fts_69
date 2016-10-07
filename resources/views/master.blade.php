<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ asset("bower/bootstrap/dist/css/bootstrap.min.css") }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset("bower/components-font-awesome/css/font-awesome.min.css") }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset("bower/Ionicons/css/ionicons.min.css") }}">
        <!-- Master -->
        <link rel="stylesheet" href="{{ asset("css/user/master.css") }}">
    </head>
    <body>
        <!-- Menu -->
        <div class="row">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">
                            <p><img src="{{ asset('/images/systems/logo.png') }}"
                                    width="30px" height="30px"> {{ trans('names.project_name') }}</p>
                        </a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="{{ $navName === config('common.menu.menu_default') ? ' active' : '' }}">
                            <a href="#">{{ trans('names.label.label_home') }}</a>
                        </li>
                        <li class="{{ $navName === config('common.menu.menu_exam') ? ' active' : '' }}">
                            <a href="#">{{ trans('names.label.label_exam') }}</a>
                        </li>
                        <li class="{{ $navName === config('common.menu.menu_suggestion') ? ' active' : '' }}">
                            <a href="#">{{ trans('names.label.label_suggestion') }}</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> {{ trans('names.label.label_profile') }}</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> {{ trans('names.label.label_sign_out') }}</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 content">
                @yield('content')
            </div>
        </div>
        <!-- jQuery 2.2.3 -->
        <script src="{{ asset("bower/jquery/dist/jquery.min.js") }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset("bower/bootstrap/dist/js/bootstrap.min.js") }}"></script>
        <!-- Master -->
        <script src="{{ asset("js/user/master.js") }}"></script>
        <!-- Suggestion -->
        <script src="{{ asset("js/user/suggestion.js") }}"></script>
    </body>
</html>


