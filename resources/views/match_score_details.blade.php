<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cricket Scorecard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
</head>
<body>

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
        <a href="{{ route('match.prediction', $match->id) }}" class="btn btn-primary">predict winning team</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
