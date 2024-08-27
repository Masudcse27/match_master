<form action="{{ route('managers.reagistration') }}" method="POST">
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

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="nid">NID</label>
        <input type="text" name="nid" id="nid" value="{{ old('nid') }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="t_manager">Team Manager</option>
            <option value="c_manager">Club Manager</option>
            <option value="g_authority">Ground Authority</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
</form>
