<!DOCTYPE html>
<html>
<head>
    <title>Create Matches</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Generated Matches</h3>
    <ul class="list-group">
        @foreach($teamPairs as $pair)
            <li class="list-group-item">
                {{ $pair['team_1']->name }} vs {{ $pair['team_2']->name }}
            </li>
        @endforeach
    </ul>
    <div class="mt-3">
        <form action="{{ route('save.matches', $tournamentId) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="matches" value="{{ json_encode($teamPairs) }}">
            <button type="submit" class="btn btn-success">Accept</button>
        </form>
        <form action="{{ route('create.feature', $tournamentId) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning">Try Again</button>
        </form>
    </div>
</div>
</body>
</html>
