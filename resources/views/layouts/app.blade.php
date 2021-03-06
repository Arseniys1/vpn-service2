<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Icon -->
    <link rel="shortcut icon" href="/favicon.png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script type="text/javascript">
        window.laravel = {
            auth: {!! Auth::check() ? 'true' : 'false' !!},
            hasActiveAccess: {!! Auth::check() ? Auth::user()->hasActiveAccess() ? 'true' : 'false' : 'false' !!}
        };
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route_locale('cabinet.index') }}">{{ __('app.cabinet') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route_locale('cabinet.tariffs') }}">{{ __('app.tariffs') }}</a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route_locale('servers.index') }}">{{ __('app.servers_list') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route_locale('servers.free') }}">{{ __('app.free_servers_list') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route_locale('cabinet.vpn.path') }}">VPN маршрут</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route_locale('cabinet.support.my_tickets') }}">{{ __('app.support') }}</a>
                        </li>

                        @if(Auth::user()->hasRole('admin'))
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('admin.users') }}">Админка</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route_locale('login') }}">{{ __('app.login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route_locale('register') }}">{{ __('app.register') }}</a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="localeSelect" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('app.locale') }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="localeSelect">
                                <a class="dropdown-item" href="{{ route('locale.change', ['locale' => 'en']) }}">
                                    English
                                </a>
                                <a class="dropdown-item" href="{{ route('locale.change', ['locale' => 'ru']) }}">
                                    Русский
                                </a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route_locale('cabinet.settings') }}">
                                    {{ __('app.settings') }}
                                </a>
                                <a class="dropdown-item" href="{{ route_locale('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('app.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route_locale('logout') }}"
                                      method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div id="errors-show">
            <errors-show-component></errors-show-component>
        </div>

        @yield('content')
    </main>
</div>
</body>
</html>
