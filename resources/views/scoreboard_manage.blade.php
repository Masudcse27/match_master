<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scoreboard Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .checkbox-group {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Scoreboard Management</h2>
        <h4>Match: {{ $match->name ?? 'Match ' . $match->id }}</h4>
        <p>Date: {{ $match->date ?? 'N/A' }}</p>

        <div class="row mt-4">
           
            <div class="col-md-4">
                <h4>Batting Team: {{ $match->battingTeam->name }}</h4>
                <ul class="list-group">
                    @foreach($battingTeamSquad as $player)
                        <li class="list-group-item">
                            <div>
                                <strong>{{ $player->name }}</strong>
                                <div class="checkbox-group mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input playing-checkbox" type="checkbox" data-player-id="{{ $player->id }}" @if(in_array($player->id, $playingBatters)) checked @endif>
                                        <label class="form-check-label">Playing</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input out-checkbox" type="checkbox" data-player-id="{{ $player->id }}" @if($player->matchBattingHistories->where('match_id', $match->id)->first()->status ?? '' === 'out') checked @endif>
                                        <label class="form-check-label">Out</label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

           
            <div class="col-md-4">
                <h4>Bowling Team: {{ $match->bowlingTeam->name }}</h4>
                <ul class="list-group">
                    @foreach($bowlingTeamSquad as $player)
                        <li class="list-group-item">
                            <div>
                                <strong>{{ $player->name }}</strong>
                                <div class="form-check mt-2">
                                    <input class="form-check-input bowling-checkbox" type="checkbox" data-player-id="{{ $player->id }}" @if($currentBowler && $currentBowler->player_id === $player->id) checked @endif>
                                    <label class="form-check-label">Bowling</label>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            
            <div class="col-md-4">
                <h4>Update Scoreboard</h4>
                <form id="scoreboard-form">
                    <div class="mb-3">
                        <label for="run" class="form-label">Run:</label>
                        <select id="run" name="run" class="form-select" required>
                            @for($i = 0; $i <= 6; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="run-type" class="form-label">Run Type:</label>
                        <select id="run-type" name="run_type" class="form-select" required>
                            <option value="no">No Ball</option>
                            <option value="lb">Leg Bye</option>
                            <option value="w">Wide</option>
                            <option value="lbw">LBW</option>
                            <option value="rw">Run Out</option>
                            <option value="b">Bye</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="facing-batter" class="form-label">Batter Facing the Ball:</label>
                        <select id="facing-batter" name="facing_player_id" class="form-select" required>
                            @foreach($battingTeamSquad as $player)
                                @if(in_array($player->id, $playingBatters))
                                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="match-id" value="{{ $match->id }}">
                    <input type="hidden" id="team-id" value="{{ $match->batting_team_id }}">
                    <input type="hidden" id="bowler-id" name="bowler_id" value="{{ $currentBowler->player_id ?? '' }}">
                    <button type="submit" class="btn btn-primary">Complete Ball</button>
                </form>
            </div>
        </div>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>

    <script>
        $(document).ready(function() {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.playing-checkbox').change(function() {
                var playerId = $(this).data('player-id');
                var isChecked = $(this).is(':checked');
                var matchId = $('#match-id').val();

                if (isChecked) {
                    
                    var playingCount = $('.playing-checkbox:checked').length;
                    if (playingCount > 2) {
                        alert('Only two players can be marked as "Playing" at a time.');
                        $(this).prop('checked', false);
                        return;
                    }

                    
                    $('.out-checkbox[data-player-id="' + playerId + '"]').prop('checked', false);
                }

                var status = isChecked ? 'playing' : 'not_play';
                updatePlayerStatus(playerId, status);
            });

            
            $('.out-checkbox').change(function() {
                var playerId = $(this).data('player-id');
                var isChecked = $(this).is(':checked');
                var matchId = $('#match-id').val();

                if (isChecked) {
                    
                    $('.playing-checkbox[data-player-id="' + playerId + '"]').prop('checked', false);
                }

                var status = isChecked ? 'out' : 'not_play';
                updatePlayerStatus(playerId, status);
            });

            
            function updatePlayerStatus(playerId, status) {
                var matchId = $('#match-id').val();
                $.ajax({
                    url: '{{ route("player.updateStatus") }}',
                    method: 'POST',
                    data: {
                        playerId: playerId,
                        status: status,
                        match_id: matchId
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('An error occurred while updating player status.');
                        }
                    }
                });
            }

            $('.bowling-checkbox').change(function() {
                var playerId = $(this).data('player-id');
                var isChecked = $(this).is(':checked');
                var matchId = $('#match-id').val();

                if (isChecked) {
                    $('.bowling-checkbox').not(this).prop('checked', false);
                    $('#bowler-id').val(playerId);
                } else {
                    $('#bowler-id').val('');
                }

                if (isChecked) {
                    updateBowlingStatus(playerId);
                } else {
                }
            });

            
            function updateBowlingStatus(playerId) {
                var matchId = $('#match-id').val();
                $.ajax({
                    url: '{{ route("player.updateBowlingStatus") }}',
                    method: 'POST',
                    data: {
                        playerId: playerId,
                        match_id: matchId
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('An error occurred while updating bowler status.');
                        }
                    }
                });
            }

            $('#scoreboard-form').submit(function(e) {
                e.preventDefault();

                var matchId = $('#match-id').val();
                var teamId = $('#team-id').val();
                var run = $('#run').val();
                var runType = $('#run-type').val();
                var facingPlayerId = $('#facing-batter').val();
                var bowlerId = $('#bowler-id').val();

                if (!bowlerId) {
                    alert('Please select a bowler.');
                    return;
                }

                $.ajax({
                    url: '{{ route("ball.complete") }}',
                    method: 'POST',
                    data: {
                        match_id: matchId,
                        team_id: teamId,
                        run: run,
                        run_type: runType,
                        facing_player_id: facingPlayerId,
                        bowler_id: bowlerId
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('An error occurred while completing the ball.');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
