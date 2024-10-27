@extends('main_view')

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
        <h2 class="text-center mb-4">Today's Matches</h2>

        <div class="row justify-content-center">
            @forelse($todayMatches as $match)
                <div class="col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('score',$match->id) }}" class="match-container">
                        <img src="{{ url('pictures/logos/mainLogo.png') }}" alt="Logo" class="logo">
                        <div class="card-body">
                            <h5 class="card-title team-names text-center">
                                <strong>{{ $match->teamOne->t_name }}</strong> vs <strong>{{ $match->teamTwo->t_name }}</strong>
                            </h5>
                            <hr class="bg-light">

                            <div class="match-status text-center mt-3">
                                @if($match->is_end)
                                    <p><strong>Team 1:</strong> {{ $match->team_1_total_run }} / {{ $match->team_1_wickets }} wickets</p>
                                    <p><strong>Team 2:</strong> {{ $match->team_2_total_run }} / {{ $match->team_2_wickets }} wickets</p>
                                @else
                                    <p><strong>Match Date:</strong> {{ $match->match_date}}</p>
                                    <p><strong>Start Time:</strong> {{ $match->start_time}}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-center text-light">No matches scheduled for today.</p>
            @endforelse
        </div>
    </div>
@stop