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
    @if(auth::guard('t_manager')->check())
        <h2 class="text-center dashboard-header">Team Manager Dashboard</h2>
    @else
        <h2 class="text-center dashboard-header">Ground Authority Dashboard</h2>
    @endif

    <!-- <div class="row"> -->
        <!-- Manager Details -->
        <div class="row">
            <div class="section-card col-md-6 bg-secondary text-white">
                <h4 class="section-header">Ground Authority Details</h4>
                <p><strong>Name:</strong> {{ $authority->name }}</p>
                <p><strong>Email:</strong> {{ $authority->email }}</p>
                <p><strong>Nid:</strong> {{ $authority->nid }}</p>
                <p><strong>Phone:</strong> {{ $authority->phone_number }}</p>
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <a class="btn btn-primary mb-3 w-50" href="{{ route('team.registration') }}">Create ground</a>
            </div>
        </div>



        <!-- Team List -->
        <div class="container mt-5">
            <!-- <div class="section-card"> -->
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <h4 class="section-header">Ground List</h4>
                    </div>
                </div>
                @if(count($grounds) > 0)
                    <div class="row">
                        @foreach($grounds as $ground)
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body bg-secondary text-white">
                                        <h5 class="card-title">{{ $ground->name}}</h5>
                                        <p><b>location: </b>{{$ground->ground_location}}</p>
                                        <p class="card-text">Cost per day: {{$ground->cost_per_day}}</p>
                                        <a href="{{ route('ground.bookings', $ground->id) }}" class="btn btn-primary">show bookings</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No ground found.</p>
                @endif
            <!-- </div> -->
        </div>


    <!-- </div> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
