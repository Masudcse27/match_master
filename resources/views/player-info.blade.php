<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .player-card {
            margin-top: 30px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .player-info {
            margin-bottom: 15px;
        }
        .player-info label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="player-card">
                <h3 class="text-center">Player Details</h3>

                <div class="player-info">
                    <label for="name">Name:</label>
                    <p id="name">{{ $player->user->name }}</p>
                </div>

                <div class="player-info">
                    <label for="player_type">Player Type:</label>
                    <p id="player_type">{{ $player->player_type }}</p>
                </div>

                <div class="player-info">
                    <label for="email">Email:</label>
                    <p id="email">{{ $player->user->email }}</p>
                </div>

                <div class="player-info">
                    <label for="address">Address:</label>
                    <p id="address">{{ $player->address ?? 'N/A' }}</p>
                </div>

                <div class="player-info">
                    <label for="total_match">Total Matches Played:</label>
                    <p id="total_match">{{ $player->total_match }}</p>
                </div>


                <div class="player-info">
                    <label for="total_run">Total Runs:</label>
                    <p id="total_run">{{ $player->total_run }}</p>
                </div>

                <div class="player-info">
                    <label for="wicket">Total Wickets:</label>
                    <p id="wicket">{{ $player->total_wicket }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
