<head>
    <style>
        .navbar {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ff5733;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }



        .navbar-toggler {
            border: none;
            background: transparent;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        /* Force burger menu to always be used */
        .navbar-collapse {
            display: none !important;

        }

        .show-menu .navbar-collapse {
            display: block !important;
        }
    </style>
</head>

<nav class="navbar">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- Toggle Button (Always Used) -->
        @auth
        <button class="navbar-toggler" type="button" id="burgerMenuToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        @endauth

        <!-- Centered Navbar Brand -->
        <a class="navbar-brand text-uppercase" href="{{ route('home') }}">
            {{ config('app.name') }}
        </a>

        <!-- Authentication & Language -->
        <div class="ms-auto d-flex align-items-center">
            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-primary">{{ __('interface.login') }}</a>
            @else
            <span class="me-3">{{ __('interface.hello', ['name' => Auth::user()->nickname ?: Auth::user()->name]) }},</span>

            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                    <span class="dropdown-toggle-text">{{ Auth::user()->nickname ?: Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('interface.profile') }}</a></li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">{{ __('interface.logout') }}</button>
                    </form>
                </ul>
            </div>
            @endguest
        </div>
    </div>

    <!-- Collapsible Menu (Always Hidden Until Clicked) -->
    <div class="navbar-collapse" id="navbarNav">
        <ul class="navbar-nav p-4">
            @auth
            @can('read ProgramSession')
            <li class="nav-item"><a class="nav-link" href="{{ route('program_sessions.index') }}">{{ __('interface.program') }}</a></li>
            @endcan
            @can('read Speaker')
            <li class="nav-item"><a class="nav-link" href="{{ route('speakers.index') }}">{{ __('interface.speakers') }}</a></li>
            @endcan
            @can('read Room')
            <li class="nav-item"><a class="nav-link" href="{{ route('rooms.index') }}">{{ __('interface.rooms') }}</a></li>
            @endcan
            @can('read User')
            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">{{ __('interface.manage_users') }}</a></li>
            @endcan
            @endauth
        </ul>
    </div>
</nav>

<script>
    document.getElementById('burgerMenuToggle').addEventListener('click', function() {
        document.querySelector('nav').classList.toggle('show-menu');
    });
</script>