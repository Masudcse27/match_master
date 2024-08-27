<div>
@if(session('Signup_success'))
    <div class="alert alert-success">
        {{ session('Signup_success') }}
    </div>
    <p>Your generated password is: <strong>{{ $password }}</strong></p>
@endif

hello
</div>
