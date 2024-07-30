<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Al-Amir</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<style>
    body::before {
        content: "";
        background-image: url('لوغو دار حفص القراءة والتجويد نهااائي.png');
        background-attachment: fixed;
        background-position: center bottom;
        background-size: cover;
        opacity: 0.1;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .navbar-brand {
        transition: transform 0.3s;
        color: #333; /* لون النص */
        padding: 0.5rem 1rem; /* تضبيط الهوامش داخل الزر */
        border-radius: 0.5rem; /* تدوير الحواف */
        background-color: #f8f9fa; /* لون الخلفية */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* ظل لتعميق الزر */
    }

    .navbar-brand:hover {
        transform: scale(1.05); /* تكبير الزر عند تحويل المؤشر فوقه */
    }

    .logo-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .navbar-toggler {
        order: -1;
    }
</style>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="logo-container">
                    <a class="navbar-brand" href="{{ url('/a') }}">
                        Home
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
  
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                <img src="{{ asset('لوغو دار حفص القراءة والتجويد نهااائي.png') }}" alt="" width="60px">

            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
