@extends('admin-nav')

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
    <div class="card p-4">
        <h2>Select Batting Team</h2>
        <p>Please select one of the teams to set as the batting team:</p>

        <form action="{{ route('set_batting_team', $matchId) }}" method="POST">
            @csrf 
            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="team_id" id="team1" value="{{ $matches->teamOne->id }}" required>
                <label class="form-check-label" for="team1">
                    {{ $matches->teamOne->t_name }} 
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="team_id" id="team2" value="{{ $matches->teamTwo->id }}" required>
                <label class="form-check-label" for="team2">
                    {{ $matches->teamTwo->t_name }} 
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Set Batting Team</button>
        </form>
    </div>
</div>
@stop