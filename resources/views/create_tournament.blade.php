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
    <div class="container mt-4">
        <h2 class="mb-4">Create Tournament</h2>

        <form action="{{ route('tournaments.store') }}" method="POST">
            @csrf
            <!-- Tournament Name -->
            <div class="form-group mb-3">
                <label for="name">Tournament Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <!-- Tournament Description -->
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            </div>
            
            <!-- Tournament Description -->
            <div class="form-group mb-3">
                <label for="entry_fee">Entry Fee for Tournament</label>
                <input type="number" name="entry_fee" id="entry_fee" value="{{ old('entry_fee') }}" class="form-control" required>
            </div>

            <!-- Registration Last Date -->
            <div class="form-group mb-3">
                <label for="registration_last_date">Registration Last Date</label>
                <input type="date" name="registration_last_date" id="registration_last_date" value="{{ old('registration_last_date') }}" class="form-control" required>
            </div>

            <!-- Tournament Start Date -->
            <div class="form-group mb-3">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control" required>
            </div>

            <!-- Tournament End Date -->
            <div class="form-group mb-3">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Create Tournament</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
