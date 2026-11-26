@extends('layouts.auth')

@section('title', 'Register')
@section('left-bg', 'var(--card-purple)')
@section('left-heading', 'Start your journey to better well-being.')
@section('left-text', 'Create an account to book sessions and track your mood securely.')

@section('form')
    <h2>Create an account</h2>
    <p>Join {{ config('app.brand_short') }} today.</p>

    @if ($errors->any())
        <div style="color:var(--text-red); background:#fee2e2; padding:10px; border-radius:8px; margin-bottom:20px; font-size:0.875rem;">
            <ul style="margin:0; padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>University Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="name@su.edu" required>
        </div>
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="At least 8 characters" required>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn-lime" style="width: 100%; margin-top: 10px;">Register</button>
    </form>

    <p style="text-align: center; margin-top: 24px; font-size: 0.875rem; color: var(--text-muted);">
        Already have an account?
        <a href="{{ route('login') }}" style="color: var(--slot-selected); font-weight: 600; text-decoration: none;">
            Log in here
        </a>
    </p>
@endsection