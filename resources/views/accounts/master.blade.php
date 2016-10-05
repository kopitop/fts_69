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
        <link rel="stylesheet" href="{{ asset("css/account/master.css") }}">
    </head>
    <body>
        <div class="content">
            @yield('content')
        </div>
        <!-- jQuery 2.2.3 -->
        <script src="{{ asset("bower/jquery/dist/jquery.min.js") }}"></script>
    </body>
</html>


