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
            background-color: #f8f9fa;
            color: #333;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }
    </style>
@stop

@section('main_content')
<div class="container mt-5">
    <h2 class="text-center">Update Profile</h2>

    <div class="form-container mt-4">
        <form action="{{ route('user.profile.update', $user->id) }}" method="POST">
            @csrf <!-- Include the CSRF token -->
            @method('POST') <!-- Use POST for the update operation -->

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
            </div>


            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number }}">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>
@stop
