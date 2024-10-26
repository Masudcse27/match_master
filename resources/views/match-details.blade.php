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
    <h2 class="text-center dashboard-header">Match Details</h2>

    <!-- <div class="row"> -->
        <!-- Manager Details -->
        <div class="container mt-5">
            <div class="section-card">
                
                 <h4>Friendly match</h4>
                <p>Match date {{$match->match_date}} at {{$match->start_time}}</p>
            </div>
            <div>
                @if (count($my_team_squads)==0)
                    <a href="{{ route('select.players', ['teamId' => $my_team->id, 'matchId' => $match->id]) }}" class="btn btn-primary">select playing XI</a>
                @elseif((\Carbon\Carbon::now('Asia/Dhaka')->format('Y-m-d') == $match->match_date 
                    && \Carbon\Carbon::now('Asia/Dhaka')->format('H:i:s') <= \Carbon\Carbon::parse($match->start_time)->format('H:i:s'))
                    || \Carbon\Carbon::now('Asia/Dhaka')->format('Y-m-d') < $match->match_date)
                    <a href="{{ route('select.players', ['teamId' => $my_team->id, 'matchId' => $match->id]) }}" class="btn btn-primary">Update Playing XI</a>
                @endif
                
            </div>
        </div>

        <div class="row m-5">
            <div class="col-md-6">
                <div>
                    <div class="row">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3>{{$my_team->t_name}}</h3>
                        </div>
                    </div>
                    @if(count($my_team_squads)>0)
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Player Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($my_team_squads as $player)
                                <tr>
                                    <td>{{ $player->player->name }}</td>
                                    <td>{{ $player->player->playerInfo->player_type }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="row">
                            <div class="d-flex align-items-center justify-content-center">
                                <h5>You are not given your squad</h5>
                            </div>
                        </div>
                        
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div>
                    <div class="row">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3>{{$opponent_team->t_name}}</h3>
                        </div>
                    </div>
                    @if(count($opponent_team_squads)>0)
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Player Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($opponent_team_squads as $player)
                                <tr>
                                    <td>{{ $player->player->name }}</td>
                                    <td>{{ $player->player->playerInfo->player_type }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="row">
                            <div class="d-flex align-items-center justify-content-center">
                                <h5>Opponent team are not given There squad</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
