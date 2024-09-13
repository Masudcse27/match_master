<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
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
        $(document).ready(function () {
            function fetchMessages() {
                var receiverId = $('#receiver_id').val();

                $.ajax({
                    url: `/messagesfetch/${receiverId}`,
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
                var message = $('#message').val();
                var receiver_id = $('#receiver_id').val();

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

            // Fetch messages every second
            setInterval(fetchMessages, 3000);

            // Initial fetch of messages
            fetchMessages();
        });


    </script>
</body>
</html>
