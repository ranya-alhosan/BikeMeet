@extends('theme.master')
@section('hero-title', 'Edit User Profile')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                            <form action="{{ route('UserProfile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                                </div>

                                <!-- Profile Picture -->
                                <div class="form-group">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required autocomplete="username">
                                </div>

                                <!-- Phone Number -->
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" class="form-control">
                                </div>

                                <!-- Country -->
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" id="country" value="{{ old('country', auth()->user()->country) }}" class="form-control">
                                </div>

                                <!-- Region -->
                                <div class="form-group">
                                    <label for="region">Region</label>
                                    <input type="text" name="region" id="region" value="{{ old('region', auth()->user()->region) }}" class="form-control">
                                </div>

                                <!-- Current Password -->
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter current password" autocomplete="current-password">
                                </div>

                                <!-- New Password -->
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" autocomplete="new-password">
                                </div>

                                <!-- Confirm New Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password" autocomplete="new-password">
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
