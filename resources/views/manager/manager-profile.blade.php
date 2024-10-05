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
    <h2 class="text-center dashboard-header">Team Manager Dashboard</h2>

    <!-- <div class="row"> -->
        <!-- Manager Details -->
        <div class="row">
            <div class="section-card col-md-6 bg-secondary text-white">
                <h4 class="section-header">Manager Details</h4>
                <p><strong>Name:</strong> {{ $manager->name }}</p>
                <p><strong>Email:</strong> {{ $manager->email }}</p>
                <p><strong>Nid:</strong> {{ $manager->nid }}</p>
                <p><strong>Phone:</strong> {{ $manager->phone_number }}</p>
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <a class="btn btn-primary mb-3 w-50" href="{{ route('team.registration') }}">Create Team</a>
                <a class="btn btn-primary w-50" href="{{route('tournaments.store')}}">Create Tournament</a>
            </div>
        </div>


        <!-- <div class="container mt-5">
            <div class="section-card">
                <h4 class="section-header">Manager Details</h4>
                <p><strong>Name:</strong> {{ $manager->name }}</p>
                <p><strong>Email:</strong> {{ $manager->email }}</p>
                <p><strong>Nid:</strong> {{ $manager->nid }}</p>
                <p><strong>Phone:</strong> {{ $manager->phone_number }}</p>
            </div>
        </div> -->

        <!-- Team List -->
        <div class="container mt-5">
            <!-- <div class="section-card"> -->
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <h4 class="section-header">Team List</h4>
                    </div>
                </div>
                @if(count($teams) > 0)
                    <div class="row">
                        @foreach($teams as $team)
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body bg-secondary text-white">
                                        <h5 class="card-title">{{ $team['t_name'] }}</h5>
                                        <p class="card-text">Teams title: {{ $team['t_title'] }}</p>
                                        <a href="{{ route('team.details', ['id' => $team['id']]) }}" class="btn btn-primary">View detiles</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No team found.</p>
                @endif
            <!-- </div> -->
        </div>


        <!-- Upcoming Tournaments -->
        <div class="container mt-5">
            <!-- <div class="section-card"> -->
                <h4 class="section-header">Upcoming Tournaments</h4>
                @if(count($tournaments) > 0)
                <div class="row"></div>
                    @foreach($tournaments as $tournament)
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body bg-secondary text-white">
                                    <h5 class="card-title">{{ $tournament['name'] }}</h5>
                                    <p class="card-text">Registration last date: {{ $tournament['registration_last_date'] }}</p>
                                    <p class="card-text">Tournament start: {{ $tournament['start_date'] }}</p>
                                    <a href="{{ route('tournament.details', ['id' => $tournament['id']]) }}" class="btn btn-primary">View details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <p>No upcoming tournaments.</p>
                @endif
            <!-- </div> -->
        </div>
        <!-- My Tournaments -->
        <div class="container mt-5">
            <!-- <div class="section-card"> -->
                <h4 class="section-header">My Tournaments</h4>
                @if(count($my_tournaments) > 0)
                <div class="row"></div>
                    @foreach($my_tournaments as $tournament)
                        <div class="col-md-4 " >
                            <div class="card mb-4">
                                <div class="card-body bg-secondary text-white">
                                    <h5 class="card-title">{{ $tournament['name'] }}</h5>
                                    <p class="card-text">Registration last date: {{ $tournament['registration_last_date'] }}</p>
                                    <p class="card-text">Tournament start: {{ $tournament['start_date'] }}</p>
                                    <a href="{{ route('tournament.details', ['id' => $tournament['id']]) }}" class="btn btn-primary">Manage Tournament</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <p>No upcoming tournaments.</p>
                @endif
            <!-- </div> -->
        </div>
    <!-- </div> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
