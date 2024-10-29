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
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <a class="btn btn-primary mb-3 w-50" href="#">Create new admin</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
