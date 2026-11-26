<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-left" style="background-color: @yield('left-bg', 'var(--bg-left-panel)');">
            <div class="brand">
                <span>🌿</span> {{ config('app.brand_short') }}
            </div>
            <div>
                @hasSection('left-eyebrow')
                    <p class="text-uppercase" style="color: var(--primary-navy); margin-bottom: 10px;">@yield('left-eyebrow')</p>
                @endif
                <h1>@yield('left-heading')</h1>
                <p>@yield('left-text')</p>
            </div>
            <div>
                @yield('left-illustration')
            </div>
        </div>

        <div class="login-right">
            <div class="login-form-container">
                @yield('form')
            </div>
        </div>
    </div>
</body>
</html>