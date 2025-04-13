@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Register</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone_numeber" class="form-control" value="{{ old('phone_numeber') }}" required>
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
@endsection
