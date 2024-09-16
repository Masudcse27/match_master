<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Team</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Join a Team</h2>
        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Join Team Form -->
        <form action="{{ route('team.registration') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="t_name" class="form-label">Team Name</label>
                <input type="text" name="t_name" class="form-control" id="t_name" value="{{ old('t_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="t_description" class="form-label">Team Description</label>
                <textarea name="t_description" class="form-control" id="t_description" rows="3" required>{{ old('t_description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="t_title" class="form-label">Team Title</label>
                <input type="text" name="t_title" class="form-control" id="t_title" value="{{ old('t_title') }}">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Join Team</button>
        </form>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
