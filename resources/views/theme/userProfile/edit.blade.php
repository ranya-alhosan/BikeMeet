@extends('theme.master')

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

                            <form action="{{ route('UserProfile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="image">Profile Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" id="country" value="{{ old('country', auth()->user()->country) }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="region">Region</label>
                                    <input type="text" name="region" id="region" value="{{ old('region', auth()->user()->region) }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter current password">
                                </div>

                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password">
                                </div>

                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
