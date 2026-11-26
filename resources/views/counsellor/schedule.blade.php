@extends('layouts.app')

@section('title', 'Schedule')
@section('nav-links')
    <a href="{{ route('counsellor.schedule') }}" class="active">Schedule</a>
@endsection

@section('content')
    <div class="page-header">
        <h1>Good morning, {{ auth()->user()->therapist?->FirstName ?? 'Counsellor' }}.</h1>
    </div>
    <div class="card card-white">
        <p class="text-muted">Your schedule will appear here.</p>
    </div>
@endsection