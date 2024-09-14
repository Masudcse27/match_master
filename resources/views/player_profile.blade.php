<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-control[disabled], .form-select[disabled] {
            background-color: #e9ecef;
            opacity: 1;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Player Profile</h3>
        </div>
        <div class="card-body">
            <form id="playerProfile">
                @csrf
                @method('PUT')

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
                    <input type="text" id="phone_number" name="phone_number" value="{{ $player->user->phone_number}}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" value="{{ $player->address ?? 'N/A' }}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="total_match" class="form-label">Total Match Played</label>
                    <textarea type="number" id="total_match" name="total_match" class="form-control" disabled>{{ $player->total_match }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="total_run" class="form-label">Total Runs</label>
                    <textarea type="number" id="total_run" name="total_run" class="form-control" disabled>{{ $player->total_run }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="wicket" class="form-label">Total Wickets</label>
                    <textarea type="number" id="wicket" name="wicket" class="form-control" disabled>{{ $player->total_wicket }}</textarea>
                </div>

                <button type="button" id="editBtn" class="btn btn-primary">Edit</button>
                <button type="submit" id="saveBtn" class="btn btn-success d-none">Save</button>
            </form>
        </div>
    </div>

    <div id="message" class="mt-3"></div>
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
            url: '{{ route("player.profile.update") }}',  // Ensure the correct route is used
            method: 'PUT',
            data: $(this).serialize(),
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

</body>
</html>
