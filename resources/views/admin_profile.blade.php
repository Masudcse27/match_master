
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
    
    <h2 class="text-center dashboard-header">Admin Dashboard</h2>

    <!-- <div class="row"> -->
        <!-- Manager Details -->
        <div class="row">
            <div class="section-card col-md-6 bg-secondary text-white">
                <h4 class="section-header">Admin Details</h4>
                <p><strong>Name:</strong> {{ $admin->name }}</p>
                <p><strong>Email:</strong> {{ $admin->email }}</p>
                <p><strong>Nid:</strong> {{ $admin->nid }}</p>
                <p><strong>Phone:</strong> {{ $admin->phone_number }}</p>
                <a class="btn btn-primary w-50" href="{{route('change.password')}}">Change password</a>
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <a class="btn btn-primary mb-3 w-50" href="{{route('admin_panel.reagistration')}}">Create new admin</a>
                <a class="btn btn-primary w-50" href="{{route('show.feedback')}}">show feedback</a>
            </div>
        </div>



        <!-- Team List -->
        <div class="container mt-5">
            <!-- <div class="section-card"> -->
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <h4 class="section-header">upcoming matches</h4>
                    </div>
                </div>
                @if(count($matches) > 0)
                    <div class="row">
                        @foreach($matches as $match)
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <p class="card-text">Match Date: {{ $match['match_date'] }}</p>
                                        <p class="card-text">Match start at: {{ $match['start_time'] }}</p>
                                        <a href="{{ route('scoreboard.show', $match->id) }}" class="btn btn-primary">manage score</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No upcoming matches.</p>
                @endif
            <!-- </div> -->
        </div>


        <!-- Upcoming Tournaments -->       
    <!-- </div> -->
</div>

@stop
