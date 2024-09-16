<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournaments</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Available Tournaments</h2>
        @if(count($tournaments) > 0)
            <div class="row">
                @foreach($tournaments as $tournament)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $tournament['name'] }}</h5>
                                <p class="card-text">Teams Registered: {{ $tournament['number_of_team_registration'] }}</p>
                                <p class="card-text">Registration Last Date: {{ \Carbon\Carbon::parse($tournament['registration_last_date'])->format('d-m-Y') }}</p>
                                <p class="card-text">Start Date: {{ \Carbon\Carbon::parse($tournament['start_date'])->format('d-m-Y') }}</p>
                                <a href="{{ route('tournaments.join', ['id' => $tournament['id']]) }}" class="btn btn-primary">Join</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">No tournaments are available for joining at the moment.</div>
        @endif
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
