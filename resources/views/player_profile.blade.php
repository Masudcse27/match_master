<!-- resources/views/player_info.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Info</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">{{ $player->user->name }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $player->player_type }}</h5>
                <p class="card-text"><strong>Address:</strong> {{ $player->address ?? 'N/A' }}</p>
                <p class="card-text"><strong>Total Matches:</strong> {{ $player->total_match }}</p>
                <p class="card-text"><strong>Total Runs:</strong> {{ $player->total_run }}</p>
                <p class="card-text"><strong>Total Wickets:</strong> {{ $player->total_wicket }}</p>
            </div>
        </div>

        
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
