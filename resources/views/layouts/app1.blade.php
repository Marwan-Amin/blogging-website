<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blogging website - Home</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('css/style.css')}}" rel="stylesheet" media="screen">
    
</head>
<body>
<!-- Start Navbar -->
<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Blogging website</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @guest
                <li>
                    <a href="{{ route('login') }}" class="padding-20">
                        <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                    </a>
                </li>
                @if (Route::has('register'))
                <li>
                    <a href="{{ route('register') }}" class="padding-20">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Register
                    </a>
                </li>
                @endif
                @else
                <li class="dropdown user-dropdown">
                    <a href="#" class="dropdown-toggle user-dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">
                        <img src="https://www.shareicon.net/data/2016/05/24/770117_people_512x512.png" width="50px" style="border: 2px solid #fff;border-radius: 50%">
                        {{ Auth::user()->name }}
                        <span class="caret"></span>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                         <i class="fa fa-sign-out fa-fw fa-lg"></i>   {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

                <!-- User Notifications -->
                <li class="dropdown notification-dropdown">
                    <a href="#" class="dropdown-toggle padding-20" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">
                        <span class="label label-danger notifications-count">1</span>
                        <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu min-width-300">
                        <li>
                            <div class="notify-wrap">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <a href="#">
                                            <img data-src="holder.js/50x50" class="img img-circle">
                                        </a>
                                    </div>
                                    <div class="col-xs-10">
                                        <div class="notify-text">
                                            <small class="notify-date text-muted">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                3 hours ago
                                            </small>
                                            <a href="#">
                                                <h4>Ahmed Fathy</h4>
                                            </a>
                                            <span>Added new comment on your post</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                        <li>
                            <div class="notify-wrap">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <a href="#">
                                            <img data-src="holder.js/50x50" class="img img-circle">
                                        </a>
                                    </div>
                                    <div class="col-xs-10">
                                        <div class="notify-text">
                                            <small class="notify-date text-muted">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                3 hours ago
                                            </small>
                                            <a href="#">
                                                <h4>Ahmed Fathy</h4>
                                            </a>
                                            <span>Added new comment on your post</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                    </ul>
                </li>
                <!-- /User Notifications -->
                @endguest
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!-- End Navbar -->

@yield('content')

<!-- jQuery -->
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<!-- Bootstrap JavaScript -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/holder.min.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
</body>
</html>