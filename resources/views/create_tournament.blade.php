<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tournament</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Form Section -->
        <div class="col-md-6 d-flex flex-column justify-content-center overflow-auto p-5">
            <h2 class="text-center mb-4">Create Tournament</h2>

            <!-- Error Message Display -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="container">
            <form action="{{ route('tournaments.store') }}" method="POST">
                @csrf

                <!-- Tournament Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tournament Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                </div>

                <!-- Tournament Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <!-- Number of Team Slot -->
                <div class="mb-3">
                    <label for="number_of_team_slot" class="form-label">Number of Team Slot</label>
                    <input type="number" name="number_of_team_slot" id="number_of_team_slot" value="{{ old('number_of_team_slot') }}" class="form-control" required>
                </div>

                <!-- Entry Fee (Only for T_Manager) -->
                @if (Auth::guard('t_manager')->check())
                    <div class="mb-3">
                        <label for="entry_fee" class="form-label">Entry Fee for Tournament</label>
                        <input type="number" name="entry_fee" id="entry_fee" value="{{ old('entry_fee') }}" class="form-control" required>
                    </div>
                @endif

                <!-- Registration Last Date -->
                <div class="mb-3">
                    <label for="registration_last_date" class="form-label">Registration Last Date</label>
                    <input type="date" name="registration_last_date" id="registration_last_date" value="{{ old('registration_last_date') }}" class="form-control" required>
                </div>

                <!-- Tournament Start Date -->
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control" required>
                </div>

                <!-- Tournament End Date -->
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control" required>
                </div>

                <!-- Venue Selection -->
                <div class="mb-3">
                    <label for="venue" class="form-label">Venue</label>
                    <select name="venue" id="venue" class="form-control" required>
                        <option value="" disabled selected>Select Venue</option>
                        @foreach ($ground as $obj)
                            <option value="{{ $obj->id }}">{{ $obj->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Create Tournament</button>
            </form>
            </div>
        </div>

        <!-- Image Section -->
        <div class="col-md-6 p-0 d-none d-md-block">
            <div class="h-100 w-100" style="background-image: url('http://127.0.0.1:8000/pictures/logos/login_baner.png'); background-size: cover; background-position: center;">
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS and Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
