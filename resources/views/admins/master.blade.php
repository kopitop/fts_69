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
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset("bower/AdminLTE/dist/css/AdminLTE.min.css") }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset("bower/AdminLTE/dist/css/skins/_all-skins.min.css") }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset("bower/AdminLTE/plugins/iCheck/flat/blue.css") }}">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{ asset("bower/AdminLTE/plugins/morris/morris.css") }}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset("bower/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{ asset("bower/AdminLTE/plugins/datepicker/datepicker3.css") }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset("bower/AdminLTE/plugins/daterangepicker/daterangepicker.css") }}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet"
              href="{{ asset("bower/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset("bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css") }}">
        <!-- Master -->
        <link rel="stylesheet" href="{{ asset("css/admin/master.css") }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">{{ trans('admins/names.logo.mini_logo_admin') }}</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">{{ trans('admins/names.logo.logo_admin') }}</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">{{ trans('admins/names.toggle_navigation') }}</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ asset(auth()->user()->avatar) }}" class="user-image"
                                         alt="User Image">
                                    <span class="hidden-xs">{{ auth()->user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{{ asset(auth()->user()->avatar) }}" class="img-circle"
                                             alt="User Image">
                                        <p>
                                            {{ auth()->user()->name }}
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{ route('admin.profile.index') }}"
                                               class="btn btn-default btn-flat">{{ trans('names.label.label_profile') }}</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('logout.index') }}"
                                               class="btn btn-default btn-flat">{{ trans('names.label.label_sign_out') }}</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar" style="height: auto;">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ asset(auth()->user()->avatar) }}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>{{ auth()->user()->name }}</p>
                            <a href="{{ route('admin.profile.index') }}">
                                <i class="fa fa-circle text-success"></i> {{ trans('names.label.label_online') }}
                            </a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">{{ trans('admins/names.label.label_admin_menu') }}</li>
                        <li class="treeview{{ $navName === config('common.menu.menu_user') ? ' active' : '' }}">
                            <a href="{{ route('admin.user.index') }}">
                                <i class="fa fa-user"></i> <span>{{ trans('admins/names.label.label_admin_user') }}</span>
                            </a>
                        </li>
                        <li class="treeview{{ $navName === config('common.menu.menu_subject') ? ' active' : '' }}">
                            <a href="{{ route('admin.subject.index') }}">
                                <i class="fa fa-book"></i> <span>{{ trans('admins/names.label.label_admin_subject') }}</span>
                            </a>
                        </li>
                        <li class="treeview{{ $navName === config('common.menu.menu_question') ? ' active' : '' }}">
                            <a href="{{ route('admin.question.index') }}">
                                <i class="fa fa-question"></i>
                                <span>{{ trans('admins/names.label.label_admin_question') }}</span>
                            </a>
                        </li>
                        <li class="treeview{{ $navName === config('common.menu.menu_question_answer') ? ' active' : '' }}">
                            <a href="{{ route('admin.question-answer.index') }}">
                                <i class="fa fa-check-square-o"></i>
                                <span>{{ trans('admins/names.label.label_admin_question_answer') }}</span>
                            </a>
                        </li>
                        <li class="treeview{{ $navName === config('common.menu.menu_exam') ? ' active' : '' }}">
                            <a href="{{ route('admin.exam.index') }}">
                                <i class="fa fa-file-text-o"></i>
                                <span>{{ trans('admins/names.label.label_admin_exam') }}</span>
                            </a>
                        </li>
                        <li class="treeview{{ $navName === config('common.menu.menu_suggestion') ? ' active' : '' }}">
                            <a href="{{ route('admin.suggestion.index') }}">
                                <i class="fa fa-lightbulb-o"></i>
                                <span>{{ trans('admins/names.label.label_admin_suggestion') }}</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        @yield('heading')
                        <small>@yield('action')</small>
                    </h1>
                </section>
                <section class="content">
                    @yield('content')
                </section>
            </div>
            <!-- /.content-wrapper -->
        </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
        <script src="{{ asset("bower/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset("bower/jquery-ui/jquery-ui.min.js") }}"></script>
        <!-- Master javascript -->
        <script src="{{ asset("js/admin/master.js") }}"></script>
        <!-- DataTables -->
        <script src="{{ asset("bower/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}"></script>
        <script src="{{ asset("bower/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ asset("bower/bootstrap/dist/js/bootstrap.min.js") }}"></script>
        <!-- Morris.js charts -->
        <script src="{{ asset("bower/raphael/raphael.min.js") }}"></script>
        <script src="{{ asset("bower/AdminLTE/plugins/morris/morris.min.js") }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset("bower/AdminLTE/plugins/sparkline/jquery.sparkline.min.js") }}"></script>
        <!-- jvectormap -->
        <script src="{{ asset("bower/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") }}"></script>
        <script src="{{ asset("bower/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js") }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset("bower/AdminLTE/plugins/knob/jquery.knob.js") }}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset("bower/moment/min/moment.min.js") }}"></script>
        <script src="{{ asset("bower/AdminLTE/plugins/daterangepicker/daterangepicker.js") }}"></script>
        <!-- datepicker -->
        <script src="{{ asset("bower/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{ asset("bower/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") }}"></script>
        <!-- Slimscroll -->
        <script src="{{ asset("bower/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
        <!-- FastClick -->
        <script src="{{ asset("bower/AdminLTE/plugins/fastclick/fastclick.js") }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset("bower/AdminLTE/dist/js/app.min.js") }}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{ asset("bower/AdminLTE/dist/js/pages/dashboard.js") }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset("bower/AdminLTE/dist/js/demo.js") }}"></script>
    </body>
</html>
