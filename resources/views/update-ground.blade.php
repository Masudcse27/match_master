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
    <h2 class="text-center">Update Ground Information</h2>

    <div class="form-container mt-4">
        <form action="{{ route('ground.update', $ground->id) }}" method="POST">
            @csrf <!-- Include the CSRF token -->
           

            <div class="mb-3">
                <label for="name" class="form-label">Ground Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $ground->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $ground->description) }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cost_per_day" class="form-label">Cost Per Day</label>
                <input type="number" name="cost_per_day" id="cost_per_day" class="form-control" value="{{ old('cost_per_day', $ground->cost_per_day) }}" required>
                @error('cost_per_day')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>
@stop
