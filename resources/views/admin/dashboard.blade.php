@extends('layouts.app')

@section('title', 'Admin')
@section('nav-links')
    <a href="{{ route('admin.dashboard') }}" class="active">Overview</a>
@endsection

@section('content')
    <div class="page-header">
        <h1>Care service at a glance.</h1>
    </div>
    <div class="card card-white">
        <p class="text-muted">User management and reports arrive next.</p>
    </div>
@endsection