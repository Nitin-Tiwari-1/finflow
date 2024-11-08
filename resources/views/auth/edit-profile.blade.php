@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
            <label for="profile_photo" class="form-label">Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control">
            @if ($user->profile_photo_path)
                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" width="100" class="mt-2">
            @endif
            @error('profile_photo')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

    <hr>

    <h2>Change Password</h2>
    <form action="{{ route('profile.change-password.post') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" required>
            @error('new_password')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>
@endsection
