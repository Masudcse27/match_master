
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2>Select 11 Players for the Match</h2>
        </div>
        <div class="card-body">

            <!-- Success message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Error message -->
            <div id="errorAlert" class="alert alert-danger d-none alert-dismissible fade show" role="alert">
                You must select exactly 11 players.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Player selection form -->
            <form action="{{ route('save.players', [$teamId, $matchId]) }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Select</th>
                                <th>Player Name</th>
                                <th>Player Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teamSquads as $squad)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input player-checkbox" 
                                                   type="checkbox" 
                                                   name="players[]" 
                                                   value="{{ $squad->player_id }}" 
                                                   id="player{{ $squad->player_id }}"
                                                   {{ in_array($squad->player_id, $selectedPlayers) ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <label for="player{{ $squad->player_id }}">
                                            {{ $squad->user->name }}
                                        </label>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $squad->user->playerInfo->player_type }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary btn-block" id="confirmSquadBtn">Confirm Squad</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#confirmSquadBtn').click(function(e) {
            var selectedPlayers = $('.player-checkbox:checked').length;

            $('#errorAlert').addClass('d-none');
            if (selectedPlayers !== 11) {
                e.preventDefault();
                $('#errorAlert').removeClass('d-none'); 
            }
        });
    });
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

@stop