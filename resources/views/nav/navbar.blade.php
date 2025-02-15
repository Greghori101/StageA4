<head>
    <style>
        .dropdown-toggle-text {
            color: #ff5733; /* Couleur personnalisée */
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
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Se déconnecter</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>

    <!-- Menu principal -->
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="{{ route('program_sessions.index') }}">Programme</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('speakers.index') }}">Orateurs</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('rooms.index') }}">Salles</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('sponsors.index') }}">Exposants</a></li>

            @auth
                @if(Auth::user()->hasRole('admin'))  <!-- Vérification du rôle avec Spatie -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Gérer les utilisateurs</a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</nav>

<!-- Navbar en bas -->
<div class="navbar-bottom">
    <div class="col text-center">
        <a href="{{ route('home') }}" class="navbar-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('program_sessions.index') }}" class="navbar-link {{ request()->routeIs('program_sessions.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Programme</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('questions.index') }}" class="navbar-link {{ request()->routeIs('questions.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-question-circle"></i>
                <span>Questions</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('sponsors.index') }}" class="navbar-link {{ request()->routeIs('sponsors.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-users"></i>
                <span>Exposants</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('favorites.index') }}" class="navbar-link {{ request()->routeIs('favorites.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-heart"></i>
                <span>Favoris</span>
            </div>
        </a>
    </div>
</div>
