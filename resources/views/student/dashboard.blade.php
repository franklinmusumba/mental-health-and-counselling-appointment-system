@extends('layouts.app')

@section('title', 'Dashboard')
@section('nav-links')
    <a href="{{ route('student.dashboard') }}" class="active">Overview</a>
    <a href="{{ route('student.book') }}">Book</a>
    <a href="#">Appointments</a>
    <a href="#">Mood check-in</a>
    <a href="#">History</a>
@endsection

@section('content')
    @if (session('success'))
        <div style="color:#166534; background:#dcfce7; padding:12px; border-radius:var(--radius-sm); margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    <p class="text-uppercase text-muted">{{ now()->format('l, j F') }}</p>
    <div class="page-header">
        <h1>Hello, {{ $patient?->FirstName ?? 'there' }}.
            <span class="italic-heading">How are you feeling today?</span>
        </h1>
        <a href="#" class="btn-outline">Daily check-in</a>
    </div>

    @if ($next)
        <div class="card card-purple">
            <div class="card-icon">📅</div>
            <div class="card-content">
                <p class="text-uppercase" style="opacity:.7; font-size:.7rem;">Coming up</p>
                <h3>Session with {{ $next->therapist->FirstName }} {{ $next->therapist->LastName }}</h3>
                <p>
                    {{ $next->AppointmentDate->format('l, j F') }} ·
                    {{ \Carbon\Carbon::parse($next->AppointmentTime)->format('g:i A') }} ·
                    Wellbeing Centre
                </p>
            </div>
            <a href="#" class="btn-outline">View details</a>
        </div>
    @else
        <div class="card card-purple">
            <div class="card-icon">🌿</div>
            <div class="card-content">
                <h3>No upcoming sessions</h3>
                <p>When you're ready, book a time that feels right.</p>
            </div>
        </div>
    @endif

    <div class="split-row">
        <a href="{{ route('student.book') }}" class="card card-lime action-card">
            <div class="card-icon">📅</div>
            <div class="card-content">
                <h3>Book appointment</h3>
                <p>Find a time that works for you</p>
            </div>
            <span aria-hidden="true">→</span>
        </a>
        <a href="#" class="card card-purple action-card">
            <div class="card-icon">💚</div>
            <div class="card-content">
                <h3>Log your mood</h3>
                <p>A gentle check-in takes one minute</p>
            </div>
            <span aria-hidden="true">→</span>
        </a>
    </div>
@endsection