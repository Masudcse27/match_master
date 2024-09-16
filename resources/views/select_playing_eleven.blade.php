<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Players</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Select 11 Players for the Match</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('save.players', [$teamId, $matchId]) }}" method="POST">
        @csrf

        <div class="form-group">
            @foreach($teamSquads as $squad)
                <div class="form-check">
                    <input class="form-check-input player-checkbox" type="checkbox" name="players[]" value="{{ $squad->player_id }}" id="player{{ $squad->player_id }}">
                    <label class="form-check-label" for="player{{ $squad->player_id }}">
                        {{ $squad->user->name }} ({{ $squad->user->playerInfo->player_type }})
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary" id="confirmSquadBtn">Confirm Squad</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#confirmSquadBtn').click(function(e) {
            var selectedPlayers = $('.player-checkbox:checked').length;
            if (selectedPlayers !== 11) {
                e.preventDefault();
                alert('You must select exactly 11 players.');
            }
        });
    });
</script>

</body>
</html>
