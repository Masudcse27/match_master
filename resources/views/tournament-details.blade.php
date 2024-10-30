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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Tournament Details</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">Tournament Name:</th>
                                    <td>{{ $tournament_details->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Description</th>
                                    <td>{{ $tournament_details->description }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Manager Name:</th>
                                    <td>{{ $tournament_details->manager->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Manager Email:</th>
                                    <td>{{ $tournament_details->manager->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tournament Start:</th>
                                    <td>{{ $tournament_details->start_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Last date of Registration:</th>
                                    <td>{{ $tournament_details->registration_last_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Registration Fee:</th>
                                    <td>{{ $tournament_details->entry_fee }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if ($is_join)
                        <div class="card-footer text-center">
                            <p class="btn btn-secondary">Already join this Tournament</p>
                        </div>
                    @elseif($is_full)
                        <div class="card-footer text-center">
                            <p class="btn btn-secondary">Tournament slot is full</p>
                        </div>
                    @else
                        <div class="card-footer text-center">
                            <a href="{{ route('tournaments.join',['id'=>$tournament_details->id,'teamId'=>$teamId]) }}" class="btn btn-secondary">Join Tournament</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
@stop
