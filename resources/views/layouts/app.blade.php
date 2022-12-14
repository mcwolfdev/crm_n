<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'STO') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/lte.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/all.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/select2.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">


    <!-- Scripts -->
    {{--@vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/sweetalert2/sweetalert2.min.js')}}"></script>

    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/select2.full.js')}}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-home"></i> {{ config('app.name', 'Laravel') }}
                    @if(Auth::user()->department)
                        [{{ Auth::user()->department->name }} - {{ Auth::user()->department->address }}]
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{route('dashboard')}}" role="button">
                                    <i class="fas fa-tasks"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{asset('')}}" role="button">
                                    <i class="fas fa-th-list"></i> ????????????
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-book"></i> ????????????????
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="/directory/provisioner"><i class="fas fa-store"></i> ????????????????????????</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-wallet"></i> ????????</a></li>
                                    <li><a class="dropdown-item" href="/directory/task"><i class="fas fa-receipt"></i> ????????????</a></li>
                                    <li><a class="dropdown-item" href="/directory/storage"><i class="fas fa-shopping-cart"></i> ???????????? (??????????)</a></li>
                                    <li><a class="dropdown-item" href="/directory/users"><i class="fas fa-user-tie"></i> ????????????????</a></li>
                                    <li><a class="dropdown-item" href="/directory/departments"><i class="fas fa-warehouse"></i> ??????????????</a></li>
                                    <li><a class="dropdown-item" href="/directory/clients"><i class="fas fa-users"></i> ??????????????</a></li>
                                    <li><a class="dropdown-item" href="/directory/vehicle"><i class="fas fa-motorcycle"></i> ???????????????????? ????????????</a></li>
                                    <li><a class="dropdown-item" href="/directory/brand"><i class="fas fa-motorcycle"></i> ????????????</a></li>
                                    <li><a class="dropdown-item" href="/directory/model"><i class="fas fa-motorcycle"></i> ????????????</a></li>
                                </ul>
                            </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> ????????????????????????
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="/settings/main"><i class="fas fa-wrench"></i> ??????????????</a></li>

                                        </ul>
                                    </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="far fa-user"></i> {{ Auth::user()->name }} ({{number_format(auth()->user()->getToPay(auth()->user()->id), 2, '.', ' ')}} ??????.)
                                </a>

                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> ??????????
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            @yield('content')
        </main>
    </div>
</body>
</html>
