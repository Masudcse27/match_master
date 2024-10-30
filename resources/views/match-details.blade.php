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
    </style>
@stop

@section('main_content')

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

@stop
