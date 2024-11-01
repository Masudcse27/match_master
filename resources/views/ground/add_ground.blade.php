@extends('ground-authority-nav')

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
    <h2>Create Ground</h2>
    <form action="{{ route('add_ground') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="ground_location">Ground Location:</label>
            <input type="text" class="form-control" id="ground_location" name="ground_location" required>
        </div>

        <div class="form-group">
            <label for="cost_per_day">Cost Per Day:</label>
            <input type="number" class="form-control" id="cost_per_day" name="cost_per_day" required>
        </div>

        

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Include Bootstrap JS (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@stop
