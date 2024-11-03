@extends('primaryview')
@section('primary_css')
  <link rel="stylesheet" href="{{asset('css/nav_bar.css')}}">
  @yield('css_content')
@stop
@section('primary_content')
    <nav class="navbar navbar-expand-lg" style="background-color: #465962;">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{route('home')}}"><img src="{{url('pictures/logos/mainLogo.png')}}" width="90" height="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{route('home')}}">HOME</a>
                </li>
                <li class="nav-item">
                <a class="nav-link " href="{{route('team.manager.profile')}}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('team.registration')}}">Create Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('tournaments.store')}}">Create Tournament</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('user.feedback')}}">Feedback</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Messages
                      <span id="unseenMessagesCount" class="badge bg-danger"></span>
                  </a>
                  <ul class="dropdown-menu" id="messagesDropdownMenu" aria-labelledby="messagesDropdown">
                      <!-- Dynamic content will be loaded here -->
                  </ul>
              </li>
                <li><a class="nav-link " href="{{route('logout')}}">Logout</a></li>
            </ul>
        </div>
      </div>
    </nav>

    @yield('main_content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    function fetchManagers() {
        console.log("Fetching managers...");
        $.ajax({
            url: '{{ route('messages.fetch.managers') }}',
            method: 'GET',
            success: function(response) {
                console.log("Managers fetched successfully:", response);
                const managers = response.managers;
                const unseenMessagesCount = response.unseenMessagesCount;

                // Update the unseen messages count in the badge
                $('#unseenMessagesCount').text(unseenMessagesCount);

                // Clear previous items and append new ones
                $('#messagesDropdownMenu').empty();
                managers.forEach(function(manager) {
                    if (manager.unseenMessagesCount > 0) {
                        const item = `<li>
                            <a class="dropdown-item" href="{{ route('messages.index', '') }}/${manager.id}">
                                ${manager.name}
                                <span class="badge bg-danger">${manager.unseenMessagesCount}</span>
                            </a>
                        </li>`;
                        $('#messagesDropdownMenu').append(item);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching managers:', error);
                console.error('Response text:', xhr.responseText);
            }
        });
    }

    // Initial fetch of managers
    fetchManagers();

    // Reload the fetchManagers function every 10 seconds (10000 milliseconds)
    setInterval(fetchManagers, 10000);
});
</script>

@stop