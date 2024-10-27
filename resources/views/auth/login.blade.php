@extends('main_view')

@section('css_content')
    <style>
        body{
            height: 100%;
            background-color:#213742;
            color:#fff;
        }

        #homeMoto{
            color:#fcca6c;
            text-align: center;
            margin-right:20%;
        }
    </style>
  {{-- <link rel="stylesheet" href="{{asset('css/signin.css')}}"> --}}
@stop

@section('main_content')

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row w-100">
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <h2 class="text-center mb-4">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
        
        <div class="col-md-6 d-flex align-items-center">
            <img src="{{url('pictures/logos/login_baner.png')}}" alt="Right Side Image" class="img-fluid w-100 mb-4">
        </div>
    </div>
</div>



@stop

