<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ground History</title>
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
            <h3>Ground History</h3>
        </div>
        <div class="card-body">
            <form id="groundForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" value="{{ $ground->name }}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="ground_location" class="form-label">Ground Location</label>
                    <input type="text" id="ground_location" name="ground_location" value="{{ $ground->ground_location }}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="cost_per_day" class="form-label">Cost Per Day</label>
                    <input type="number" id="cost_per_day" name="cost_per_day" value="{{ $ground->cost_per_day }}" class="form-control" disabled>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" disabled>{{ $ground->description }}</textarea>
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
        $('form#groundForm .form-control, form#groundForm textarea').prop('disabled', false);
        $('#editBtn').addClass('d-none');
        $('#saveBtn').removeClass('d-none');
    });

    $('#groundForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("ground.update", $ground->id) }}', // Update with your route
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#message').html('<div class="alert alert-success">Update successful!</div>');
                $('form#groundForm .form-control, form#groundForm textarea').prop('disabled', true);
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
