<div>
@if(session('Signup_success'))
    <div class="alert alert-success">
        {{ session('Signup_success') }}
    </div>
@endif

hello <br>
<a href="{{route('login')}}">Login</a> <br>
<a href="{{route('managers.reagistration')}}">Registration</a>
</div>
