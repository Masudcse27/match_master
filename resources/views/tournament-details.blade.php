<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Tournament Details</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">Tournament Name:</th>
                                    <td>{{ $tournament_details->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Description</th>
                                    <td>{{ $tournament_details->description }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Manager Name:</th>
                                    <td>{{ $tournament_details->manager->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Manager Email:</th>
                                    <td>{{ $tournament_details->manager->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tournament Start:</th>
                                    <td>{{ $tournament_details->start_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Last date of Registration:</th>
                                    <td>{{ $tournament_details->registration_last_date }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Registration Fee:</th>
                                    <td>{{ $tournament_details->entry_fee }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('tournaments.join',$tournament_details->id) }}" class="btn btn-secondary">Back to Tournaments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
