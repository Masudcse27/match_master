
@extends('admin-nav')

@section('css_content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
          body {
            height: 100%;
            background-color: #213742;
            color: #fff;
        }

        #homeMoto {
            color: #fcca6c;
            text-align: center;
            margin-right: 20%;
        }

        .match-container {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            background-color: #ffffff; /* Set background color to white */
            border: none; /* Removes the card border */
            width: 250px; /* Set a fixed width for a smaller card */
            position: relative; /* To position the logo */
            text-decoration: none; /* Removes underline from link */
            color: #213742; /* Set a contrasting text color for visibility */
            transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
            display: block; /* Make the anchor behave like a block element */
        }

        .match-container:hover {
            background-color: #f0f0f0; /* Light gray background on hover */
            transform: scale(1.05); /* Slightly enlarge the card */
        }

        .logo {
            position: absolute;
            top: 10px; /* Adjust the position as needed */
            left: 10px; /* Adjust the position as needed */
            width: 40px; /* Set a fixed width for the logo */
            height: auto; /* Maintain aspect ratio */
        }

        .team-names, .match-status {
            font-size: 16px; /* Slightly smaller font size */
            color: #213742; /* Ensure text color is dark for visibility */
        }
        .dashboard-header {
            margin-top: 30px;
        }
        .section-card {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .section-header {
            font-weight: bold;
            margin-bottom: 15px;
        }
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
@stop
@section('main_content')
<div class="container mt-5">
        <div class="card p-4">
            <h2 class="mb-4 text-center">Scoreboard Management</h2>
            <h4 class="text-center">{{ $match->battingTeam->t_name }} vs {{ $match->bowlingTeam->t_name }}</h4>
            <p class="text-center">Date: {{ $match->matches->match_date ?? 'N/A' }}</p>

            <div class="row mt-4">
                <!-- Batting Team Section -->
                <div class="col-md-4">
                    <h4 class="mb-3">Batting Team: {{ $match->battingTeam->t_name }}</h4>
                    <ul class="list-group">
                        @foreach($battingTeamSquad as $player)
                            <li class="list-group-item">
                                <strong>{{ $player->player->name }}</strong>
                                <div class="checkbox-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input playing-checkbox" type="checkbox" data-player-id="{{ $player->player->id }}" @if(in_array($player->player->id, $playingBatters)) checked @endif>
                                        <label class="form-check-label">Playing</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input out-checkbox" type="checkbox" data-player-id="{{ $player->player->id }}" @if(in_array($player->player->id, $outBatters)) checked @endif>
                                        <label class="form-check-label">Out</label>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Bowling Team Section -->
                <div class="col-md-4">
                    <h4 class="mb-3">Bowling Team: {{ $match->bowlingTeam->t_name }}</h4>
                    <ul class="list-group">
                        @foreach($bowlingTeamSquad as $player)
                            <li class="list-group-item">
                                <strong>{{ $player->player->name }}</strong>
                                <div class="form-check mt-2">
                                    <input class="form-check-input bowling-checkbox" type="checkbox" data-player-id="{{ $player->player->id }}" @if($currentBowler && $currentBowler->player_id === $player->player->id) checked @endif>
                                    <label class="form-check-label">Bowling</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Update Scoreboard Section -->
                <div class="col-md-4">
                    <h4 class="mb-3">Update Scoreboard</h4>
                    <form id="scoreboard-form">
                        @csrf <!-- CSRF token added here -->
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
                                <option> value="no">No Ball</option>
                                <option value="lb">Leg Bye</option>
                                <option value="w">Wicket</option>
                                <option value="lbw">LBW</option>
                                <option value="rw">Run Out</option>
                                <option value="wd">Wide</option>
                                <option value="b">Ball</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="facing-batter" class="form-label">Batter Facing the Ball:</label>
                            <select id="facing-batter" name="facing_player_id" class="form-select" required>
                                @foreach($battingTeamSquad as $player)
                                    @if(in_array($player->player->id, $playingBatters))
                                        <option value="{{ $player->player->id }}">{{ $player->player->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="match-id" value="{{ $match->id }}">
                        <input type="hidden" id="team-id" value="{{ $match->batting_team_id }}">
                        <input type="hidden" id="bowler-id" name="bowler_id" value="{{ $currentBowler->player_id ?? '' }}">
                        <button type="submit" class="btn btn-primary w-100">Complete Ball</button>
                    </form>
                </div>
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

            function updateFacingBatterDropdown() {
                var $facingBatterDropdown = $('#facing-batter');
                $facingBatterDropdown.empty(); // Clear current options

                // Find checked playing batters and add them to the dropdown
                $('.playing-checkbox:checked').each(function() {
                    var playerId = $(this).data('player-id');
                    var playerName = $(this).closest('.list-group-item').find('strong').text();
                    $facingBatterDropdown.append(`<option value="${playerId}">${playerName}</option>`);
                });

                // Ensure there are exactly 2 players in the dropdown
                // if ($facingBatterDropdown.children().length !== 2) {
                //     alert('Please select exactly 2 players as "Playing".');
                // }
            }

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

                updateFacingBatterDropdown();
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

                updateFacingBatterDropdown();
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
@stop
