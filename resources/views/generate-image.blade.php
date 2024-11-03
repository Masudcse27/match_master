<!DOCTYPE html>
<html>
<head>
    <title>Text-to-Image Generator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Generate an Image with Your Text</h1>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#imageForm').on('submit', function(event) {
            event.preventDefault();
            let prompt = $('#prompt').val();
            let negativePrompt = $('#negative_prompt').val();

            $.ajax({
                url: "{{ route('generate.image') }}",
                method: 'POST',
                data: {
                    prompt: prompt,
                    negative_prompt: negativePrompt,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.image_url) {
                        $('#generatedImage').attr('src', response.image_url).show();
                    } else {
                        alert('Image URL not found.');
                    }
                },
                error: function() {
                    alert('Failed to generate image.');
                }
            });
        });
    </script>
</body>
</html>
