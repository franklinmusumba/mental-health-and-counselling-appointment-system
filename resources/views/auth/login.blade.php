@extends('layouts.auth')

@section('title', 'Login')
@section('left-eyebrow', 'A Private Space For You')
@section('left-heading', 'Welcome back. Take a breath.')
@section('left-text', 'Your appointments, mood check-ins and support — all in one calm place.')

@section('form')
    <p class="text-uppercase" style="color: var(--primary-navy); margin-bottom: 8px;">Sign In</p>
    <h2>Good to see you again</h2>
    <p>Enter your university email to continue.</p>

    @if (session('registered'))
        <p style="color:#166534; background:#dcfce7; padding:10px; border-radius:8px; margin-bottom:20px; font-size:0.875rem;">
            Registration successful! Please log in.
        </p>
    @endif

    @if (session('error'))
        <p style="color:var(--text-red); background:#fee2e2; padding:10px; border-radius:8px; margin-bottom:20px; font-size:0.875rem;">
            {{ session('error') }}
        </p>
    @endif

    @if ($errors->any())
        <p style="color:var(--text-red); background:#fee2e2; padding:10px; border-radius:8px; margin-bottom:20px; font-size:0.875rem;">
            {{ $errors->first() }}
        </p>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">University email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control" placeholder="name@su.edu" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password"
                   class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn-lime" style="width: 100%; margin-top: 10px;">Log in</button>
    </form>

    <p style="text-align: center; margin-top: 24px; font-size: 0.875rem; color: var(--text-muted);">
        New to {{ config('app.brand_short') }}?
        <a href="{{ route('register') }}" style="color: var(--slot-selected); font-weight: 600; text-decoration: none;">
            Create an account
        </a>
    </p>
@endsection