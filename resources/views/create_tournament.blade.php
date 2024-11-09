@php
    if (Auth::guard('admin')->check()) {
        $layout = 'admin-nav';
    } elseif (Auth::guard('t_manager')->check()) {
        $layout = 'team-manager-nav';
    } elseif (Auth::guard('c_manager')->check()) {
        $layout = 'club-manager-nav';
    }
@endphp
@extends($layout)

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
    </style>
@stop

@section('main_content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Form Section -->
        <div class="col-md-6 d-flex flex-column justify-content-center overflow-auto p-5">
            <h2 class="text-center mb-4">Create Tournament</h2>

            <!-- Error Message Display -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="container">
            <form action="{{ route('tournaments.store') }}" method="POST">
                @csrf

                <!-- Tournament Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tournament Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                </div>

                <!-- Tournament Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <!-- Number of Team Slot -->
                <div class="mb-3">
                    <label for="number_of_team_slot" class="form-label">Number of Team Slot</label>
                    <input type="number" name="number_of_team_slot" id="number_of_team_slot" value="{{ old('number_of_team_slot') }}" class="form-control" required>
                </div>

                <!-- Entry Fee (Only for T_Manager) -->
                @if (Auth::guard('t_manager')->check())
                    <div class="mb-3">
                        <label for="entry_fee" class="form-label">Entry Fee for Tournament</label>
                        <input type="number" name="entry_fee" id="entry_fee" value="{{ old('entry_fee') }}" class="form-control" required>
                    </div>
                @endif

                <!-- Registration Last Date -->
                <div class="mb-3">
                    <label for="registration_last_date" class="form-label">Registration Last Date</label>
                    <input type="date" name="registration_last_date" id="registration_last_date" value="{{ old('registration_last_date') }}" class="form-control" required>
                </div>

                <!-- Tournament Start Date -->
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control" required>
                </div>

                <!-- Tournament End Date -->
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control" required>
                </div>

                <!-- Venue Selection -->
                <div class="mb-3">
                    <label for="venue" class="form-label">Venue</label>
                    <select name="venue" id="venue" class="form-control" required>
                        <option value="" disabled selected>Select Venue</option>
                        @foreach ($ground as $obj)
                            <option value="{{ $obj->id }}">{{ $obj->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Create Tournament</button>
            </form>
            </div>
            <div class="container mt-5">
                <h1 class="text-center mb-4">Generate a banner with Your Text</h1>
                <form id="imageForm" method="POST" action="{{ route('generate.image') }}">
                    @csrf <!-- CSRF token is required for POST requests -->
                    
                    <div class="mb-3">
                        <label for="prompt" class="form-label">Prompt (Your Text)</label>
                        <input type="text" class="form-control" id="prompt" name="prompt" placeholder="Enter your text here">
                    </div>
                    <div class="mb-3">
                        <label for="negative_prompt" class="form-label">Negative Prompt</label>
                        <input type="text" class="form-control" id="negative_prompt" name="negative_prompt" placeholder="Enter negative prompt">
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Image</button>
                </form>

                <div id="imageResult" class="text-center mt-4">
                    <img id="generatedImage" class="img-fluid" style="display: none;" alt="Generated Image">
                </div>
            </div>
        </div>
        
        <!-- Image Section -->
        <div class="col-md-6 p-0 d-none d-md-block">
            <div class="h-100 w-100" style="background-image: url('http://127.0.0.1:8000/pictures/logos/login_baner.png'); background-size: cover; background-position: center;">
            </div>
        </div>
    </div>
    
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    $(document).ready(function () {
        $('#imageForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the form from submitting normally

            // Retrieve form data
            let formData = {
                prompt: $('#prompt').val(),
                negative_prompt: $('#negative_prompt').val(),
                _token: $('input[name="_token"]').val() // CSRF token
            };

            // Make AJAX request
            $.ajax({
                url: $(this).attr('action'), // Form action URL
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response.output && response.output[0]) {
                        // Display the generated image
                        $('#generatedImage').attr('src', response.output[0]);
                        $('#generatedImage').show();
                    } else {
                        alert('Failed to generate image. Please try again.');
                    }
                },
                error: function (xhr) {
                    // Handle error
                    alert('An error occurred: ' + xhr.responseJSON.error);
                }
            });
        });
    });
</script>
@stop
