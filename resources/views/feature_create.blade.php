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
<div class="container mt-5">
    <h3>Generated Matches</h3>
    <ul class="list-group">
        @foreach($teamPairs as $pair)
            <li class="list-group-item">
                {{ $pair['team_1']}} vs {{ $pair['team_2'] }}
            </li>
        @endforeach
    </ul>
    @if (count($teamPairs)>0)
        <div class="mt-3">
            <form action="{{ route('save.matches', $tournamentId) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="matches" value="{{ json_encode($teamPairs) }}">
                <button type="submit" class="btn btn-success">Accept</button>
            </form>
            <form action="{{ route('create.feature', $tournamentId) }}" method="GET" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning">Try Again</button>
            </form>
        </div>
    @else
        <h5>No team join this tournament</h5>
    @endif
    
</div>
@stop
