<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Manager Registration</h2>

        <form action="{{ route('managers.reagistration') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                <div class="invalid-feedback">
                    Please enter your name.
                </div>
            </div>

            <div class="mb-3">
                <label for="nid" class="form-label">NID</label>
                <input type="text" name="nid" id="nid" value="{{ old('nid') }}" class="form-control" required>
                <div class="invalid-feedback">
                    Please enter your NID.
                </div>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="form-control" required>
                <div class="invalid-feedback">
                    Please enter your phone number.
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <div class="invalid-feedback">
                    Please enter a password.
                </div>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="t_manager">Team Manager</option>
                    <option value="c_manager">Club Manager</option>
                    <option value="g_authority">Ground Authority</option>
                </select>
                <div class="invalid-feedback">
                    Please select a role.
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</body>
</html>
