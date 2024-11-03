@extends('primaryview')
@section('primary_css')
  <link rel="stylesheet" href="{{asset('css/nav_bar.css')}}">
  @yield('css_content')
@stop
@section('primary_content')
    <nav class="navbar navbar-expand-lg" style="background-color: #465962;">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="{{url('pictures/logos/mainLogo.png')}}" width="90" height="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{route('home')}}">HOME</a>
                </li>
                <!-- <li class="nav-item">
                <a class="nav-link " href="#">PROBLEMSET</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#">RANKS</a>
                </li> -->

            </ul>
            <!-- //@if(//Auth::check()) -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
                    <!-- <li class="nav-item dropdown"> -->
                        <!-- <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-pic">
                                <img src="#" alt="Profile Picture">
                            </div> -->
                        <!-- You can also use icon as follows: -->
                        <!--  <i class="fas fa-user"></i> -->
                        <!-- </a> -->
                        <!-- <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sliders-h fa-fw"></i> Account</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog fa-fw"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a></li>
                        </ul> -->
                    <!-- </li> -->
                     <li><a class="nav-link " href="{{route('login')}}">Login</a></li>
                     <li><a class="nav-link " href="{{route('managers.reagistration')}}">Register</a></li>
                </ul>
            <!-- //@endif -->
        </div>
      </div>
    </nav>

    @yield('main_content')


@stop