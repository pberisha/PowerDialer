
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ Auth::user()->remember_token }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  </head>

  <body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow navbar-laravel">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">
                @guest
                    {{ config('app.name', 'Laravel') }}
                @else
                    {{ Auth::user()->domain() }} | {{ config('app.name', 'Laravel') }}
                @endguest
            </a>
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item">Domain: {{ Auth::user()->domain() }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </nav>

        <div class="container-fluid">
        <div class="row">
            @include('layouts.navigation')

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                @yield('breadcrumbs')
            </div>
            @yield('content')
            </main>
        </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        @yield('script')
        feather.replace()
    </script>

  </body>
</html>
