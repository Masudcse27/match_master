<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Tournament</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Join Tournament</h2>
    <form action="{{ route('tournaments.join', $id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="team_name" class="form-label">Team Name</label>
            <input type="text" class="form-control" id="team_name" name="team_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Join Tournament</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
