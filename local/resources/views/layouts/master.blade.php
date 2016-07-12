<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <base href="/">
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">
    <!-- Font Awesome  -->       
        <link rel="stylesheet" type="text/css" href="{{URL::asset('bower_components/font-awesome/css/font-awesome.min.css')}}">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}"> 
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/self/universal.css')}}">
</head>
<body id="app-layout" ng-app="taskListApp" ng-controller="taskListController">

    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Simple Task List Manager
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        @if (Auth::user()->role == 'admin')
                            <li><a href="{{ url('/admin/home') }}"><i class="fa fa-btn fa-sign-out"></i>Administration</a></li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if (Auth::user()->firstname || Auth::user()->lastname)
                                    {{ Auth::user()->firstname }} {{Auth::user()->lastname}} &nbsp;<span class="caret"></span>
                                @else
                                    My Account &nbsp;<span class="caret"></span>
                                @endif
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li><a href="{{ route('tasks.index') }}"><i class="fa fa-btn fa-file"></i> My Tasks</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @if (Session::has('message'))
      <div class="flash alert-info col-md-8 col-md-offset-2" style="margin-top: 15px">
        <p class="panel-body">
          {{ Session::get('message') }}
        </p>
      </div>
    @endif
    @yield('content')

    <!-- JavaScripts -->
    <script type="text/javascript" src="{{URL::asset('app/lib/angular/angular.min.js')}}"></script>
   <script type="text/javascript" src="{{URL::asset('app/lib/angular/ui-bootstrap-tpls-1.3.3.min.js')}}"></script>
   <script type="text/javascript" src="{{URL::asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

   <script type="text/javascript" src="{{URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script> 
   <script type="text/javascript" src="{{URL::asset('javascript/self/myjs.js')}}"></script>
   <script type="text/javascript" src="{{URL::asset('app/lib/app.js')}}"></script>
   <script type="text/javascript" src="{{URL::asset('app/controllers/app_controller.js')}}"></script>
</body>
</html>
