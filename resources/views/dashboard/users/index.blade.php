@extends('dashboard.layout')

@section('users-active', 'active')

@section('content')
    <div class="container">
        <h1 class="mt-4">User & Admin Management</h1>

        <!-- Success and Danger messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('danger'))
            <div class="alert alert-danger">{{ session('danger') }}</div>
        @endif

        <!-- Search Form and Add New User Button -->
        <form method="GET" action="{{ route('users.index') }}" class="mt-4">
            <div class="row g-3 align-items-center">
                <!-- Search Bar -->
                <div class="col-md-6">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by name, email, or role"
                        value="{{ request('search') }}"
                    >
                </div>
                <!-- Search Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Search
                    </button>
                </div>
                <!-- Clear Button -->
                <div class="col-md-2">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
                <!-- Add New User Button -->
                <div class="col-md-2 text-end">
                    <a href="{{ route('users.create') }}" class="btn btn-success w-100">Add New User</a>
                </div>
            </div>
        </form>

        <!-- Users Table -->
        @if ($users->isNotEmpty())
            <h2 class="mt-5">Users</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination for Users -->
            {{ $users->links() }}
        @endif

        <!-- Admins Table -->
        @if ($admins->isNotEmpty())
            <h2 class="mt-5">Admins</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->role }}</td>
                        <td>
                            <a href="{{ route('users.edit', $admin) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('users.destroy', $admin) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination for Admins -->
            {{ $admins->links() }}
        @endif

        <!-- If no results, show a message -->
        @if ($users->isEmpty() && $admins->isEmpty())
            <p class="text-center">No results found.</p>
        @endif
    </div>
@endsection
