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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div id="errorAlert" class="alert alert-danger d-none alert-dismissible fade show" role="alert">
        You must select exactly 11 players.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form action="{{ route('save.players', [$teamId, $matchId]) }}" method="POST">
        @csrf

        <div class="form-group">
            @foreach($teamSquads as $squad)
                <div class="form-check">
                    <input class="form-check-input player-checkbox" 
                           type="checkbox" 
                           name="players[]" 
                           value="{{ $squad->player_id }}" 
                           id="player{{ $squad->player_id }}"
                           {{ in_array($squad->player_id, $selectedPlayers) ? 'checked' : '' }}>
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

            $('#errorAlert').addClass('d-none');
            if (selectedPlayers !== 11) {
                e.preventDefault();
                $('#errorAlert').removeClass('d-none'); 
            }
        });
    });
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
