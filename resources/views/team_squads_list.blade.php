<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Squads List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Team Squads</h1>
        
        @if($teamSquads->isEmpty())
            <div class="alert alert-info" role="alert">
                No players in your squad.
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Player Name</th>
                        <th>Player Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teamSquads as $teamSquad)
                        <tr>
                            <td>{{ $teamSquad->user->name ?? 'No Name' }}</td>
                            <td>{{ $teamSquad->user->playerInfo->player_type ?? 'No Type' }}</td>
                            <td>
                                <form action="{{ route('team_squads.destroy', $teamSquad->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
