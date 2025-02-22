<head>
    <style>
        .dropdown-toggle-text {
            color: #ff5733;
            /* Couleur personnalisée */
        }
    </style>
</head>

<!-- Navbar principale (en haut) -->
<nav class="navbar">
    <div class="container-fluid d-flex align-items-center">
        <!-- Bouton de toggle pour le menu (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Titre de la navbar (centré) -->
        <div class="text-center flex-grow-1">
            <a class="navbar-brand fw-bold text-uppercase" href="{{ route('home') }}" style="font-size: 1.8rem; letter-spacing: 1px; color: #e0e0e0;">
                {{ config('app.name') }}
            </a>
        </div>

        <!-- Authentification -->
        <div class="ms-auto d-flex align-items-center">
            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Se connecter</a>
            @else
            <span class="me-3">Bonjour,</span>

            <!-- Dropdown utilisateur -->
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="dropdown-toggle-text">{{ Auth::user()->surnom ?: Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a href="{{ route('profile.show') }}" class="dropdown-item">Mon Profil</a></li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Se déconnecter</button>
                    </form>
                </ul>
            </div>
            @endguest
        </div>
    </div>

    <!-- Menu principal -->
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @auth
                @if(Auth::user()->can('read ProgramSession'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('program_sessions.index') }}">Programme</a></li>
                @endif

                @if(Auth::user()->can('read Speaker'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('speakers.index') }}">Orateurs</a></li>
                @endif

                @if(Auth::user()->can('read Room'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('rooms.index') }}">Salles</a></li>
                @endif

                @if(Auth::user()->can('read Sponsor'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('sponsors.index') }}">Exposants</a></li>
                @endif

                @if(Auth::user()->can('read Question'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('questions.index') }}">Questions</a></li>
                @endif

                @if(Auth::user()->can('read Favorite'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('favorites.index') }}">Favoris</a></li>
                @endif

                @if(Auth::user()->can('read User'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Gérer les utilisateurs</a></li>
                @endif
            @endauth
        </ul>
    </div>
</nav>
