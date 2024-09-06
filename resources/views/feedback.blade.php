<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <!-- Include Bootstrap CSS for styling (optional) -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Feedback</h2>
    <form action="{{ route('user.feedback') }}" method="POST">
    @csrf      
        <div class="form-group">
            <label for="feedback">Enter your feedback </label>
            <textarea name="feedback" class="form-control" id="feedback" rows="7"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Done</button>
        <!-- Display error messages if available -->
        
    </form>
</div>

<!-- Include Bootstrap JS (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

