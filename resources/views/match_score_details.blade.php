
@php
    if (Auth::guard('admin')->check()) {
        $layout = 'admin-nav';
    } elseif (Auth::guard('t_manager')->check()) {
        $layout = 'team-manager-nav';
    } elseif (Auth::guard('c_manager')->check()) {
        $layout = 'club-manager-nav';
    } elseif (Auth::guard('g_authority')->check()) {
        $layout = 'ground-authority-nav';
    } elseif (Auth::check()) {
        $layout = 'player_nav';
    } else {
        $layout = 'main_view';
    }
@endphp
@extends($layout)

@section('css_content')
    <style>
          body {
            height: 100%;
            background-color: #213742;
            /* color: #fff; */
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

        .scorecard {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-top: 20px;
            padding: 15px;
        }
        .scorecard-title {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .batting-table th, .bowling-table th {
            background-color: #e9ecef;
        }
        .batting-table, .bowling-table {
            margin-bottom: 20px;
        }
        .extras, .fall-of-wickets, .powerplay {
            margin-top: 20px;
        }
    </style>
@stop

@section('main_content')
<div class="container">
    <div class="scorecard">
        <div class="scorecard-title">{{$match->teamOne->id==$batting_team?$match->teamOne->t_name:$match->teamTwo->t_name}} {{$match->teamOne->id==$batting_team?$match->team_1_total_run:$match->team_2_total_run}} / {{$match->teamOne->id==$batting_team?$match->team_1_wickets:$match->team_2_wickets}}</div>

        <!-- Batting Table -->
        <table class="table table-bordered table-sm batting-table">
            <thead>
                <tr>
                    <th>Batter</th>
                    <th>R</th>
                    <th>B</th>
                    <th>SR</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($batting_team_score as $player_score)
                    @if ($player_score->status!="not_play")
                        <tr>
                            <td>{{$player_score->player->name}} <br> {{$player_score->status}}</td>
                            <td>{{$player_score->run}}</td>
                            <td>{{$player_score->ball}}</td>
                            <td>{{$player_score->ball>0?($player_score->run/$player_score->ball)*100:0}}</td>
                        </tr>
                    @endif
                    
                @endforeach
            </tbody>
        </table>

        <!-- Bowling Table -->
        <table class="table table-bordered table-sm bowling-table">
            <thead>
                <tr>
                    <th>Bowler</th>
                    <th>O</th>
                    <th>R</th>
                    <th>W</th>
                    <th>ECO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bowling_history as $player_ball)
                    <tr>
                        <td>{{$player_ball->player->name}}</td>
                        <td>{{$player_ball->over>0?(int)($player_ball->over/6):0}}{{$player_ball->over>0 &&($player_ball->over%6)>0?'.':''}}{{$player_ball->over>0&&($player_ball->over%6)?(int)($player_ball->over%6):''}}</td>
                        <td>{{$player_ball->run}}</td>
                        <td>{{$player_ball->wicket}}</td>
                        <td>{{$player_ball->over>0?number_format(($player_ball->run / $player_ball->over) * 6, 2):0}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (count($bowling_team_batting)>0)
            <div class="scorecard-title">{{$match->teamOne->id!=$batting_team?$match->teamOne->t_name:$match->teamTwo->t_name}} {{$match->teamOne->id!=$batting_team?$match->team_1_total_run:$match->team_2_total_run}} / {{$match->teamOne->id!=$batting_team?$match->team_1_wickets:$match->team_2_wickets}}</div>

            <!-- Batting Table -->
            <table class="table table-bordered table-sm batting-table">
                <thead>
                    <tr>
                        <th>Batter</th>
                        <th>R</th>
                        <th>B</th>
                        <th>SR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bowling_team_batting as $player_score)
                        @if ($player_score->status!="not_play")
                            <tr>
                                <td>{{$player_score->player->name}} <br> {{$player_score->status}}</td>
                                <td>{{$player_score->run}}</td>
                                <td>{{$player_score->ball}}</td>
                                <td>{{$player_score->ball>0?($player_score->run/$player_score->ball)*100:0}}</td>
                            </tr>
                        @endif
                        
                    @endforeach
                </tbody>
            </table>

            <!-- Bowling Table -->
            <table class="table table-bordered table-sm bowling-table">
                <thead>
                    <tr>
                        <th>Bowler</th>
                        <th>O</th>
                        <th>R</th>
                        <th>W</th>
                        <th>ECO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($batting_team_bowling as $player_ball)
                        <tr>
                            <td>{{$player_ball->player->name}}</td>
                            <td>{{$player_ball->over>0?(int)($player_ball->over/6):0}}{{$player_ball->over>0 &&($player_ball->over%6)>0?'.':''}}{{$player_ball->over>0&&($player_ball->over%6)?(int)($player_ball->over%6):''}}</td>
                            <td>{{$player_ball->run}}</td>
                            <td>{{$player_ball->wicket}}</td>
                            <td>{{$player_ball->over>0?number_format(($player_ball->run / $player_ball->over) * 6, 2):0}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <form action="{{route('match.prediction', $match->id)}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="team">Select a Team:</label>
            <div>
                <input type="radio" id="team1" name="team" value="{{$match->team_1}}" required>
                <label for="team1">{{$match->teamOne->t_name}} : {{$prediction_1}}%</label>
            </div>
            <div>
                <input type="radio" id="team2" name="team" value="{{$match->team_2}}">
                <label for="team2">{{$match->teamTwo->t_name}} : {{$prediction_2}}%</label>
            </div>
        </div>        
        <button type="submit" class="btn btn-primary">Submit Prediction</button>
    </form>
    </div>
</div>

@stop
