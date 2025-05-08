<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CongeFlow - Gestion des Congés')</title>
    
    <!-- Preload des ressources critiques -->
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Animations fluides */
        .fade-enter-active, .fade-leave-active {
            transition: opacity 0.3s ease;
        }
        .fade-enter-from, .fade-leave-to {
            opacity: 0;
        }
        
        /* Styles de navigation */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #3B82F6;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .nav-link.active::after {
            width: 100%;
        }
        
        /* Loading spinner */
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3B82F6;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive improvements */
        @media (max-width: 640px) {
            .mobile-menu {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .mobile-menu.active {
                transform: translateX(0);
            }
        }
    </style>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100" x-data="{ mobileMenuOpen: false, loading: false }">
    <!-- Loading Overlay -->
    <div x-show="loading" 
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
         x-cloak>
        <div class="spinner"></div>
    </div>

    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white shadow-md relative z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo et Bouton Menu Mobile -->
                    <div class="flex items-center">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 md:hidden">
                            <span class="sr-only">Ouvrir le menu</span>
                            <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                        </button>
                        
                        <div class="flex-shrink-0 flex items-center ml-4 md:ml-0">
                            <i class="fas fa-calendar-alt text-blue-600 text-2xl mr-2"></i>
                            <span class="font-bold text-gray-900 text-xl">CongeFlow</span>
                        </div>
                    </div>

                    <!-- Navigation Desktop -->
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.rh.index') }}" class="nav-link {{ request()->routeIs('admin.rh.*') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-users-cog mr-2"></i> Utilisateurs RH
                            </a>
                            <a href="{{ route('admin.statistiques') }}" class="nav-link {{ request()->routeIs('admin.statistiques') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-chart-bar mr-2"></i> Statistiques
                            </a>
                        @elseif(auth()->user()->role === 'rh')
                            <a href="{{ route('hr.gestion_conges') }}" class="nav-link {{ request()->routeIs('hr.gestion_conges') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-tasks mr-2"></i> Gestion des congés
                            </a>
                            <a href="{{ route('conges.index') }}" class="nav-link {{ request()->routeIs('conges.index') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-list-alt mr-2"></i> Demandes
                            </a>
                            <a href="{{ route('hr.salaries.index') }}" class="nav-link {{ request()->routeIs('hr.salaries.*') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-users mr-2"></i> Salariés
                            </a>
                            <a href="{{ route('hr.configuration_conges') }}" class="nav-link {{ request()->routeIs('hr.configuration_conges') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-cog mr-2"></i> Config
                            </a>
                            <a href="{{ route('hr.suivi_absences') }}" class="nav-link {{ request()->routeIs('hr.suivi_absences') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-calendar-check mr-2"></i> Absences
                            </a>
                        @else
                            <a href="{{ route('employee.solde') }}" class="nav-link {{ request()->routeIs('employee.solde') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-calculator mr-2"></i> Solde
                            </a>
                            <a href="{{ route('conges.index') }}" class="nav-link {{ request()->routeIs('conges.index') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-file-alt mr-2"></i> Demandes
                            </a>
                            <a href="{{ route('employee.historique') }}" class="nav-link {{ request()->routeIs('employee.historique') ? 'active text-blue-600' : 'text-gray-500 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                                <i class="fas fa-history mr-2"></i> Historique
                            </a>
                        @endif
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center">
                        <div class="ml-3 relative" x-data="{ userMenuOpen: false }">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <button @click="userMenuOpen = !userMenuOpen" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
                                        <span class="sr-only">Menu utilisateur</span>
                                        @if(auth()->user()->photoProfile)
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . auth()->user()->photoProfile) }}" alt="{{ auth()->user()->nom }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium">
                                                {{ substr(auth()->user()->prenom, 0, 1) }}{{ substr(auth()->user()->nom, 0, 1) }}
                                            </div>
                                        @endif
                                    </button>
                                    
                                    <div x-show="userMenuOpen" 
                                         @click.away="userMenuOpen = false"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                         x-cloak>
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-user-edit mr-2"></i> Mon profil
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="text-sm font-medium text-gray-700 hidden md:block">
                                    {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div class="md:hidden" x-show="mobileMenuOpen" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                <div class="pt-2 pb-3 space-y-1">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.rh.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.rh.*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-users-cog mr-2"></i> Utilisateurs RH
                        </a>
                        <a href="{{ route('admin.statistiques') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.statistiques') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-chart-bar mr-2"></i> Statistiques
                        </a>
                    @elseif(auth()->user()->role === 'rh')
                        <a href="{{ route('hr.gestion_conges') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('hr.gestion_conges') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-tasks mr-2"></i> Gestion des congés
                        </a>
                        <a href="{{ route('conges.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('conges.index') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-list-alt mr-2"></i> Demandes
                        </a>
                        <a href="{{ route('hr.salaries.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('hr.salaries.*') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-users mr-2"></i> Gestion des salariés
                        </a>
                        <a href="{{ route('hr.configuration_conges') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('hr.configuration_conges') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-cog mr-2"></i> Configuration
                        </a>
                        <a href="{{ route('hr.suivi_absences') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('hr.suivi_absences') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-calendar-check mr-2"></i> Suivi des absences
                        </a>
                    @else
                        <a href="{{ route('employee.solde') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('employee.solde') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-calculator mr-2"></i> Solde de congés
                        </a>
                        <a href="{{ route('conges.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('conges.index') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-file-alt mr-2"></i> Mes demandes
                        </a>
                        <a href="{{ route('employee.historique') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('employee.historique') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                            <i class="fas fa-history mr-2"></i> Historique
                        </a>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert"
                         x-data="{ show: true }" 
                         x-show="show" 
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                         x-data="{ show: true }" 
                         x-show="show" 
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-inner mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} CongeFlow - Tous droits réservés
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts globaux -->
    <script>
        // Fonction pour afficher le spinner de chargement
        function showLoading() {
            Alpine.store('loading', true);
        }
        
        // Fonction pour cacher le spinner de chargement
        function hideLoading() {
            Alpine.store('loading', false);
        }
        
        // Intercepter les soumissions de formulaire pour afficher le spinner
        document.addEventListener('submit', function(e) {
            if (!e.target.classList.contains('no-loading')) {
                showLoading();
            }
        });
        
        // Intercepter les clics sur les liens pour afficher le spinner
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && !link.classList.contains('no-loading') && !link.getAttribute('target')) {
                showLoading();
            }
        });
    </script>
    
    @stack('scripts')
</body>

</html>
