@extends('team-manager-nav')

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
        body {
            font-family: Arial, sans-serif;
            background-color: #ece5dd;
            margin: 0;
            padding: 0;
        }
        .chat-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message-container {
            overflow-y: auto;
            max-height: 400px;
        }
        .message {
            padding: 10px;
            margin: 5px;
            border-radius: 8px;
            max-width: 60%;
            position: relative;
            clear: both;
            word-wrap: break-word;
        }
        .sent {
            background-color: #DCF8C6; /* Light green for sent messages */
            margin-left: auto; /* Align to the right */
            text-align: right;
        }
        .received {
            background-color: #ffffff; /* White for received messages */
            margin-right: auto; /* Align to the left */
            text-align: left;
        }
        .input-group {
            display: flex;
            margin-top: 20px;
        }
        .input-group input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }
        .input-group button {
            padding: 10px 15px;
            background-color: #34B7F1;
            border: none;
            color: white;
            border-radius: 20px;
            margin-left: 10px;
        }
    </style>
@stop

@section('main_content')
<div class="chat-container">
        <div id="message-container" class="message-container">
            @foreach($messages as $message)
                <div class="message {{ $message->sender_id == Auth::guard('t_manager')->user()->id ? 'sent' : 'received' }}">
                    {{ $message->message }}
                </div>
            @endforeach
        </div>

        <div class="input-group">
            <input type="text" id="message" placeholder="Type a message...">
            <input type="hidden" id="receiver_id" value="{{ $receiverId }}">
            <button id="send">Send</button>
        </div>
    </div>

    <script>
        $('#send').on('click', function () {
    var message = $('#message').val();
    var receiver_id = $('#receiver_id').val();

    if (message.trim() === '') {
        alert("Message cannot be empty!");
        return; // Prevent sending empty messages
    }

    $.ajax({
        url: "{{ route('messages.store') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            message: message,
            receiver_id: receiver_id
        },
        success: function (data) {
            var messageClass = data.sender_id == "{{ Auth::guard('t_manager')->user()->id }}" ? 'sent' : 'received';
            $('#message-container').append('<div class="message ' + messageClass + '">' + data.message + '</div>');
            $('#message').val(''); // Clear input field
            $('#message-container').scrollTop($('#message-container')[0].scrollHeight);
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
});


    </script>
@stop
