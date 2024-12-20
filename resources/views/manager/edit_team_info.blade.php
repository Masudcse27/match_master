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

        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #213742;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
@stop

@section('main_content')
<div class="container mt-5">
    <h2 class="text-center">Update Team Details</h2>

    <div class="form-container mt-4">
        <form action="{{ route('team.update', $team->id) }}" method="POST">
            @csrf <!-- Include the CSRF token -->
            
            <div class="mb-3">
                <label for="t_name" class="form-label">Team Name</label>
                <input type="text" name="t_name" id="t_name" class="form-control" value="{{ $team->t_name }}" required>
            </div>

            <div class="mb-3">
                <label for="t_description" class="form-label">Team Description</label>
                <input type="text" name="t_description" id="t_description" class="form-control" value="{{ $team->t_description }}" required>
            </div>

            <div class="mb-3">
                <label for="t_title" class="form-label">Team Title</label>
                <input type="text" name="t_title" id="t_title" class="form-control" value="{{ $team->t_title }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Team</button>
        </form>
    </div>
</div>
@stop
