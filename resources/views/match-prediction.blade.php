<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Match Prediction</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Match Prediction</h2>
    <form action="{{route('match.prediction', $id)}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="team">Select a Team:</label>
            <div>
                <input type="radio" id="team1" name="team" value="{{$matches->team_1}}" required>
                <label for="team1">{{$matches->teamOne->t_name}}</label>
            </div>
            <div>
                <input type="radio" id="team2" name="team" value="{{$matches->team_2}}">
                <label for="team2">{{$matches->teamTwo->t_name}}</label>
            </div>
        </div>        
        <button type="submit" class="btn btn-primary">Submit Prediction</button>
    </form>
</div>
</body>
</html>
