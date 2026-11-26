<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="top-nav">
        <div class="nav-brand">
            <span>🌿</span> {{ config('app.brand_short') }}
        </div>

        <div class="nav-links">
            @yield('nav-links')
        </div>

        <div class="nav-user">
            <div class="avatar">{{ auth()->user()->initials() }}</div>
            <div class="user-info">
                <span class="name">{{ auth()->user()->displayName() }}</span>
                <span class="role">{{ auth()->user()->Role }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout"
                        style="background:none;border:none;cursor:pointer;padding:0;">
                    Log out
                </button>
            </form>
        </div>
    </nav>

    <div class="dashboard-container">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>