@extends('dashboard.layout')

@section('users-active', 'active')

@section('content')
    <div class="container">
        <h1>Edit User</h1>

        <!-- Success message (if any) -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password">
                <small class="form-text text-muted">Leave blank if you do not want to change the password.</small>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation">
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input
                    type="text"
                    class="form-control"
                    id="phone_number"
                    name="phone_number"
                    value="{{ old('phone_number', $user->phone_number) }}">
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input
                    type="text"
                    class="form-control"
                    id="country"
                    name="country"
                    value="{{ old('country', $user->country) }}">
            </div>

            <div class="mb-3">
                <label for="region" class="form-label">Region</label>
                <input
                    type="text"
                    class="form-control"
                    id="region"
                    name="region"
                    value="{{ old('region', $user->region) }}">
            </div>

{{--            <div class="mb-3">--}}
{{--                <label for="profile_picture" class="form-label">Profile Picture</label>--}}
{{--                <input--}}
{{--                    type="file"--}}
{{--                    class="form-control"--}}
{{--                    id="profile_picture"--}}
{{--                    name="profile_picture">--}}
{{--                @if($user->profile_picture)--}}
{{--                    <div>--}}
{{--                        <img src="{{  asset('storage/' . $user->profile_picture)  }}" alt="Profile Picture" width="100">--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
