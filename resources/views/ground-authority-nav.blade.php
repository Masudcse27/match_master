@extends('primaryview')
@section('primary_css')
  <link rel="stylesheet" href="{{asset('css/nav_bar.css')}}">
  @yield('css_content')
@stop
@section('primary_content')
    <nav class="navbar navbar-expand-lg" style="background-color: #465962;">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{route('home')}}"><img src="{{url('pictures/logos/mainLogo.png')}}" width="90" height="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{route('home')}}">HOME</a>
                </li>
                <li class="nav-item">
                <a class="nav-link " href="{{route('ground.authority.profile')}}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('add_ground')}}">Add Ground</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('user.feedback')}}">Feedback</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
                <li><a class="nav-link " href="{{route('logout')}}">Logout</a></li>
            </ul>
        </div>
      </div>
    </nav>

    @yield('main_content')


@stop