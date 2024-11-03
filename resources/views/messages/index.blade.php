@extends('team-manager-nav')

@section('css_content')
    <style>
        body {
            height: 100%;
            background-color: #213742;
            /* color: #fff; */
        }

        #homeMoto {
            color: #fcca6c;
            text-align: center;
            margin-right: 20%;
        }

        .chat-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 80vh; /* Adjust as needed */
        }

        .message-container {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .message {
            padding: 10px;
            margin: 5px;
            border-radius: 8px;
            max-width: 60%;
            word-wrap: break-word;
        }

        .sent {
            background-color: #DCF8C6; /* Light green for sent messages */
            margin-left: auto;
            text-align: right;
        }

        .received {
            background-color: #ffffff; /* White for received messages */
            margin-right: auto;
            text-align: left;
        }

        .input-group {
            display: flex;
            padding: 10px;
            background-color: #f1f1f1;
            border-top: 1px solid #ddd;
        }

        .input-group input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
        }

        .input-group button {
            padding: 10px 15px;
            background-color: #34B7F1;
            border: none;
            color: white;
            border-radius: 20px;
            margin-left: 10px;
            cursor: pointer;
            outline: none;
        }

        .input-group button:hover {
            background-color: #2585b2; /* Darker blue on hover */
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Load Bootstrap JS (Make sure to load after jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function () {
    function fetchMessages() {
        var receiverId = $('#receiver_id').val();
        $.ajax({
            url: `/messages-fetch/${receiverId}`, // Updated to match the defined route
            method: 'GET',
            success: function (data) {
                var messageContainer = $('#message-container');
                messageContainer.empty();
                data.forEach(function (message) {
                    var messageClass = message.sender_id == "{{ Auth::guard('t_manager')->user()->id }}" ? 'sent' : 'received';
                    messageContainer.append('<div class="message ' + messageClass + '">' + message.message + '</div>');
                });
                // Scroll to the bottom of the message container
                messageContainer.scrollTop(messageContainer[0].scrollHeight);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }

    $('#send').on('click', function () {
        var message = $('#message').val().trim();
        var receiver_id = $('#receiver_id').val();

        // Prevent sending empty messages
        if (message === '') {
            alert("Message cannot be empty!");
            return;
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
                $('#message').val('');
                $('#message-container').scrollTop($('#message-container')[0].scrollHeight);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });

    // Fetch messages every 3 seconds
    setInterval(fetchMessages, 3000);
    // Initial fetch of messages
    fetchMessages();
});
</script>
@stop
