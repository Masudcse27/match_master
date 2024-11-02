@php
    if (Auth::guard('admin')->check()) {
        $layout = 'admin-nav';
    } elseif (Auth::guard('t_manager')->check()) {
        $layout = 'team-manager-nav';
    } elseif (Auth::guard('c_manager')->check()) {
        $layout = 'club-manager-nav';
    } elseif (Auth::guard('g_authority')->check()) {
        $layout = 'ground-authority-nav';
    } elseif (Auth::check()) {
        $layout = 'player_nav';
    } else {
        $layout = 'main_view';
    }
@endphp
@extends($layout)

@section('css_content')
    <style>
          body {
            height: 100%;
            background-color: #213742;
            color: #fff;
        }

        #homeMoto {
            color: #fcca6c;
            text-align: center;
            margin-right: 20%;
        }

        .match-container {
    margin-top: 20px;
    padding: 15px;
    border-radius: 10px;
    background-color: #ffffff; /* Set background color to white */
    border: none; /* Removes the card border */
    width: 250px; /* Set a fixed width for a smaller card */
    position: relative; /* To position the logo */
    text-decoration: none; /* Removes underline from link */
    color: #213742; /* Set a contrasting text color for visibility */
    transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
    display: block; /* Make the anchor behave like a block element */
}

.match-container:hover {
    background-color: #f0f0f0; /* Light gray background on hover */
    transform: scale(1.05); /* Slightly enlarge the card */
}

.logo {
    position: absolute;
    top: 10px; /* Adjust the position as needed */
    left: 10px; /* Adjust the position as needed */
    width: 40px; /* Set a fixed width for the logo */
    height: auto; /* Maintain aspect ratio */
}

.team-names, .match-status {
    font-size: 16px; /* Slightly smaller font size */
    color: #213742; /* Ensure text color is dark for visibility */
}
    </style>
@stop

@section('main_content')
<div class="container mt-5">
    <div class="card p-4">
        <h3 class="mb-4">Change Password</h3>
        
        <!-- Display any error messages -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('change.password') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="previous_password" class="form-label">Previous Password</label>
                <input type="password" name="previous_password" id="previous_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Change Password</button>
        </form>
    </div>
</div>
@stop