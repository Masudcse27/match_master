@php
    if (Auth::guard('admin')->check()) {
        $layout = 'admin-nav';
    } elseif (Auth::guard('t_manager')->check()) {
        $layout = 'team-manager-nav';
    } elseif (Auth::guard('c_manager')->check()) {
        $layout = 'club-manager-nav';
    }
@endphp
@extends($layout)

@section('css_content')
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
    </style>
@stop

@section('main_content')

<div class="container mt-5">
    <h2 class="text-center dashboard-header">Team Details</h2>

    <!-- <div class="row"> -->
        <!-- Manager Details -->
        <div class="row">
            <div class="section-card col-md-6 bg-secondary text-white">
                <h4 class="section-header">Team Details</h4>
                <p><strong>Name:</strong> {{ $team->t_name }}</p>
                <p><strong>Title:</strong> {{ $team->t_title }}</p>
                <p><strong>Description:</strong> {{ $team->t_description }}</p>
            </div>
            <div class="container mt-2 col-md-6">
                <div class="container m-3">
                    @if (Auth::guard('t_manager')->check())
                        <h4>Request For Friendly Match</h4>
                        <form action="{{route('friendly.match.request',$team->id)}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="friendly_match">Team Name</label>
                                <input class="form-control" type="text" id="friendly_match" name="team_name" placeholder="Team_name" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="match_date">Team Name</label>
                                <input class="form-control" type="date" id="match_date" name="date" placeholder="Match date" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="match_time">Team Name</label>
                                <input class="form-control" type="time" id="match_time" name="time" placeholder="Match time" class="form-control">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Make Request</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-md-6">
                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('add.player.team',$team->id) }}" method="POST">
                    @csrf
                    <label for="add_player">Add a New Player</label>
                    <input type="email" id="add_player" name="player_email" placeholder="Enter the player's email" class="form-control">
                    <button type="submit" class="btn btn-primary">Add Player</button>
                </form>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-end">
            @if (Auth::guard('t_manager')->check())<a type="button" href="{{route('player.reagistration',$team->id)}}" class="btn btn-primary">Create New Player</a>@endif
            </div>
        </div>

        <!-- Team Squad List -->
        <div class="container mt-5">
            <h2 class="mb-4">Team Squad List</h2>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($squad) > 0)
                    @foreach ($squad as $member)
                    <tr>
                        <td>{{ $member->user->name }}</td>
                        <td>{{ $member->user->phone_number }}</td>
                        <td>{{ $member->user->email }}</td>
                        <td>
                            <!-- Remove button (with confirmation) -->
                            <form action="{{route('team.squad.remove', ['team_id' => $team->id, 'player_id' => $member->user->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            @if(count($squad) == 0)
                <p>No player found in your team squad.</p>
            @endif
        </div>

        <!-- Upcoming Matches -->
        <div class="container mt-5">
            <!-- <div class="section-card"> -->
                <h4 class="section-header">Upcoming Matches for your team</h4>
                @if(count($matches) > 0)
                    <div class="row">
                        @foreach($matches as $match)
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <p class="card-text">Match Date: {{ $match['match_date'] }}</p>
                                        <p class="card-text">Match start at: {{ $match['start_time'] }}</p>
                                        <a href="{{ route('match.details', ['match_id' => $match->id, 'team_id' => $team->id]) }}" class="btn btn-primary">View details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No upcoming matches.</p>
                @endif
            <!-- </div> -->
        </div>

        <!-- requested match -->
        @if (Auth::guard('t_manager')->check())

            <div class="container mt-5">
                <h4 class="section-header">Upcoming Tournaments</h4>
                <!-- Search Input -->
                <div class="mb-3">
                    <label for="tournament-search" class="form-label">Search Tournament</label>
                    <div class="input-group" style="width: 300px;"> <!-- Adjust the width here -->
                        <span class="input-group-text" id="search-icon">
                            <i class="bi bi-search"></i> <!-- Bootstrap search icon -->
                        </span>
                        <input type="text" id="tournament-search" class="form-control" placeholder="Enter tournament name...">
                    </div>
                </div>

                @if(count($tournaments) > 0)
                    <div class="row" id="tournament-list">
                        @foreach($tournaments as $tournament)
                            <div class="col-md-4 tournament-item">
                                <div class="card mb-4">
                                    <div class="card-body bg-secondary text-white">
                                        <h5 class="card-title">{{ $tournament['name'] }}</h5>
                                        <p class="card-text">Registration last date: {{ $tournament['registration_last_date'] }}</p>
                                        <p class="card-text">Tournament start: {{ $tournament['start_date'] }}</p>
                                        <a href="{{ route('tournament.details', ['id' => $tournament['id'], 'teamId'=>$team->id]) }}" class="btn btn-primary">View details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No upcoming tournaments.</p>
                @endif
            </div>
            <div class="container mt-5">
                <!-- <div class="section-card"> -->
                    <h4 class="section-header">Friendly Match Request</h4>
                    @if(count($match_request) > 0)
                        <div class="row">
                            @foreach($match_request as $match)
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h4>Requested team: {{ $match->teamOne->t_name }}</h4>
                                            <p class="card-text">Match Date: {{ $match['match_date'] }}</p>
                                            <p class="card-text">Match time: {{ $match['start_time'] }}</p>
                                            <a href="{{ route('friendly.match.request.accept', $match->id) }}" class="btn btn-primary">Accept</a>
                                            <a href="{{ route('friendly.match.request.reject', $match->id) }}" class="btn btn-primary">Reject</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No Request for Friendly Match</p>
                    @endif
                <!-- </div> -->
            </div>
        @endif

    <!-- </div> -->
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript for Filtering Tournaments
    document.getElementById('tournament-search').addEventListener('input', function() {
        var query = this.value.toLowerCase();
        var tournamentItems = document.querySelectorAll('.tournament-item');

        tournamentItems.forEach(function(item) {
            var tournamentName = item.querySelector('.card-title').textContent.toLowerCase();
            if (tournamentName.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
@stop
