@extends('player_nav')

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
    <div class="card">
        <div class="card-header">
            <h3>Player Profile</h3>
        </div>
        <div class="card-body">
            <form id="playerProfile">
                @csrf
                @method('PUT') <!-- Needed for the form to recognize it as a PUT request -->
                <div id="message" class="mt-3"></div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" value="{{ $player->user->name }}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="player_type" class="form-label">Player Type</label>
                    <input type="text" id="player_type" name="player_type" value="{{ $player->player_type }}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ $player->user->phone_number }}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" value="{{ $player->address ?? 'N/A' }}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="total_match" class="form-label">Total Match Played</label>
                    <textarea id="total_match" name="total_match" class="form-control" disabled>{{ $playing_match }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="total_run" class="form-label">Total Scored Runs</label>
                    <textarea id="total_run" name="total_run" class="form-control" disabled>{{ $all_run }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="run_conceded" class="form-label">Total Run Conceded</label>
                    <textarea id="run_conceded" name="run_conceded" class="form-control" disabled>{{ $total_given_run }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="wicket" class="form-label">Total Wickets</label>
                    <textarea id="wicket" name="wicket" class="form-control" disabled>{{ $total_wicket }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="batting_average" class="form-label">Batting Average</label>
                    <textarea id="batting_average" name="batting_average" class="form-control" disabled>{{ $total_out?$all_run/$total_out:$all_run }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="bowling_average" class="form-label">Bowling Average</label>
                    <textarea id="bowling_average" name="bowling_average" class="form-control" disabled>{{ $total_wicket>0?$total_given_run/$total_wicket:0 }}</textarea>
                </div>

                <button type="button" id="editBtn" class="btn btn-primary">Edit</button>
                <button type="submit" id="saveBtn" class="btn btn-success d-none">Save</button>
            </form>
        </div>
        <a class="btn btn-primary w-50" href="{{route('change.password')}}">Change password</a>
    </div>

    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#editBtn').on('click', function() {
        $('#name, #phone_number, #address').prop('disabled', false);
        $('#editBtn').addClass('d-none');
        $('#saveBtn').removeClass('d-none');
    });

    $('#playerProfile').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("player.profile.update") }}',
            method: 'POST', // Use POST for AJAX request
            data: $(this).serialize() + '&_method=PUT', // Append _method=PUT to simulate PUT request
            success: function(response) {
                $('#message').html('<div class="alert alert-success">Update successful!</div>');
                $('#name, #phone_number, #address').prop('disabled', true);
                $('#editBtn').removeClass('d-none');
                $('#saveBtn').addClass('d-none');
            },
            error: function(xhr) {
                $('#message').html('<div class="alert alert-danger">Update failed. Please try again.</div>');
            }
        });
    });
});
</script>

@stop
