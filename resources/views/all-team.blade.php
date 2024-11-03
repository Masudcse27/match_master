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
            background-color: #ffffff;
            border: none;
            width: 250px;
            position: relative;
            text-decoration: none;
            color: #213742;
            transition: background-color 0.3s, transform 0.3s;
            display: block;
        }

        .match-container:hover {
            background-color: #f0f0f0;
            transform: scale(1.05);
        }

        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 40px;
            height: auto;
        }

        .team-names, .match-status {
            font-size: 16px;
            color: #213742;
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
    </style>
    <!-- Add Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@stop

@section('main_content')

<div class="container mt-5">
    <h2 class="text-center dashboard-header">Team Details</h2>
    <div class="container mt-5">
        <h2 class="mb-4">Team Squad List</h2>

        <!-- Search Input -->
        <div class="mb-3">
            <label for="tournament-search" class="form-label">Search Tournament</label>
            <div class="input-group" style="width: 300px;"> <!-- Adjust the width here -->
                <span class="input-group-text" id="search-icon">
                    <i class="bi bi-search"></i> <!-- Bootstrap search icon -->
                </span>
                <input type="text" id="tournament-search" class="form-control" placeholder="Enter tournament name...">
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Team name</th>
                    <th>Manager name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="teamTableBody">
                @if(count($teams) > 0)
                    @foreach ($teams as $team)
                        <tr>
                            <td>{{ $team->t_name }}</td>
                            <td>{{ $team->manager->name }}</td>
                            <td>
                                <a href="{{ route('messages.index', $team->t_manager) }}" class="btn btn-primary">Message</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if(count($teams) == 0)
            <p>No Team Found</p>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Search Functionality
    $(document).ready(function() {
        $('#tournament-search').on('keyup', function() {
            let searchValue = $(this).val().toLowerCase();
            $('#teamTableBody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });
    });
</script>
@stop
