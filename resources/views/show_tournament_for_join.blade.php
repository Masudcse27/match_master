@extends('team-manager-nav')

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
@stop
