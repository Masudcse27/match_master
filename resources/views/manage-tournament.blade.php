<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Tournament Details</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">Tournament Name:</th>
                                    <td>{{ $tournament_details->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Description</th>
                                    <td>{{ $tournament_details->description }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Manager Name:</th>
                                    <td>{{ $tournament_details->manager->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Manager Email:</th>
                                    <td>{{ $tournament_details->manager->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tournament Start:</th>
                                    <td>{{ $tournament_details->start_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Last date of Registration:</th>
                                    <td>{{ $tournament_details->registration_last_date }}</td>
                                </tr>
                                @if (!Auth::guard('c_manager')->check())
                                    <tr>
                                        <th scope="row">Registration Fee:</th>
                                        <td>{{ $tournament_details->entry_fee }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($matches)==0)
    @if (Auth::guard('c_manager')->check())
        
        <div>
            <form action="{{ route('add.team',$tournament_details->id) }}" method="POST">
                @csrf
                <label for="team_name">Add Team</label>
                <input type="text" id="team_name" name="team_name" placeholder="team_name" class="form-control">
                <button type="submit" class="btn btn-primary">Add Player</button>
            </form>
        </div>
        
    @endif
    <div class="container">
        <h5>Team list</h5>
        @foreach ($teams as $team)
            <p>{{$team->team->t_name}}</p>
        @endforeach
    </div>
    @endif
    @if(count($matches)>0)
        <div class="container mt-5">
            <h2 class="mb-4">Match List</h2>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Match</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matches as $match)
                        <tr>
                            @if (!$match->is_end)
                                <form action="{{ route('set.date', $match->id) }}" method="POST">
                                    @csrf
                                    <td>{{ $match->teamOne->t_name }} vs {{ $match->teamTwo->t_name }}</td>
                                    <td>
                                        <input class="form-control" type="date" name="date" 
                                            value="{{ $match->match_date ? \Carbon\Carbon::parse($match->match_date)->format('Y-m-d') : '' }}"
                                            placeholder="Match date" required>
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" name="time" 
                                        value="{{ $match->start_time ? \Carbon\Carbon::parse($match->start_time)->format('H:i') : '' }}" 
                                            placeholder="Match time" required>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-danger">
                                            {{ $match->match_date ? 'Change Date & Time' : 'Add Date & Time' }}
                                        </button>
                                    </td>
                                </form>
                            @else
                                <td>{{ $match->teamOne->t_name }} vs {{ $match->teamTwo->t_name }}</td>
                                <td>{{$match->match_date}}</td>
                                <td>{{$match->start_time}}</td>
                                <td><a href="{{ route('score', $match->id) }}" class="btn btn-primary">score</a></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <a href="{{ route('create.feature', $tournament_details->id) }}" class="btn btn-primary">create feature</a>
    @endif
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
