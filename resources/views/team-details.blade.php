<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center dashboard-header">Team Details</h2>

    <!-- <div class="row"> -->
        <!-- Manager Details -->
        <div class="row">
            <div class="section-card col-md-6 align-items-center">
                <h4 class="section-header">Team Details</h4>
                <p><strong>Name:</strong> {{ $team->t_name }}</p>
                <p><strong>Title:</strong> {{ $team->t_title }}</p>
                <p><strong>Description:</strong> {{ $team->t_description }}</p>
            </div>
            <div class="container mt-2 col-md-6">
                <div class="container m-3">
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
                <a type="button" href="{{route('player.reagistration',$team->id)}}" class="btn btn-primary">Create New Player</a>
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

    <!-- </div> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
