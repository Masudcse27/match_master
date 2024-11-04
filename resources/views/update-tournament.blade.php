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
    <h2 class="text-center">Update Tournament Information</h2>

    <div class="form-container mt-4">
        <form action="{{ route('tournament.update', $tournament->id) }}" method="POST">
            @csrf <!-- Include the CSRF token -->
            @method('POST') <!-- Use POST for the update operation -->

            <div class="mb-3">
                <label for="name" class="form-label">Tournament Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $tournament->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $tournament->description) }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="registration_last_date" class="form-label">Registration Last Date</label>
                <input type="date" name="registration_last_date" id="registration_last_date" class="form-control" value="{{ old('registration_last_date', $tournament->registration_last_date) }}" required>
                @error('registration_last_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $tournament->start_date) }}" required>
                @error('start_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $tournament->end_date) }}" required>
                @error('end_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>
@stop
