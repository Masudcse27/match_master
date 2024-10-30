@extends('club-manager-nav')

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
@stop

@section('main_content')

<div class="container mt-5">
    <h2 class="text-center dashboard-header">Club Manager Dashboard</h2>
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

        <!-- My Tournaments -->
        <div class="container mt-5">
            <!-- <div class="section-card"> -->
                <h4 class="section-header">My Tournaments</h4>
                @if(count($my_tournaments) > 0)
                <div class="row">
                    @foreach($my_tournaments as $tournament)
                        <div class="col-md-4 " >
                            <div class="card mb-4">
                                <div class="card-body bg-secondary text-white">
                                    <h5 class="card-title">{{ $tournament['name'] }}</h5>
                                    <p class="card-text">Registration last date: {{ $tournament['registration_last_date'] }}</p>
                                    <p class="card-text">Tournament start: {{ $tournament['start_date'] }}</p>
                                    <a href="{{ route('tournament.manage', ['id' => $tournament['id']]) }}" class="btn btn-primary">Manage Tournament</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <p>No tournaments found</p>
                @endif
            <!-- </div> -->
        </div>
    <!-- </div> -->
</div>

@stop
