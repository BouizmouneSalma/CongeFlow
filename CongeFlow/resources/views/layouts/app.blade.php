<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion des Congés</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-600 text-2xl mr-2"></i>
                            <span class="font-bold text-gray-900 text-xl">CongeFlow</span>
                </div>
                        <div class=" sm:ml-6 sm:flex sm:space-x-8">

                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.rh.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Utilisateurs RH
                                </a>
                                <a href="{{ route('admin.statistiques') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Statistiques
                                </a>
                            @elseif(auth()->user()->role === 'rh')
                                <a href="{{ route('hr.gestion_conges') }}" class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Gestion des congés
                    </a>
                                <a href="{{ route('conges.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Demandes
                                </a>
                                <a href="{{ route('hr.salaries.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Gestion des salariés
                    </a>
                                <a href="{{ route('hr.configuration_conges') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Configuration
                    </a>
                                <a href="{{ route('hr.suivi_absences') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Suivi des absences
                    </a>
                            @else
                                <a href="{{ route('employee.solde') }}" class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Solde de congés
                                </a>
                                <a href="{{ route('conges.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Mes demandes
                                </a>
                                <a href="{{ route('employee.historique') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Historique
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                             
                                <div class="relative ml-3" x-data="{ open: false }">
                                    <div>
                                        <button @click="open = !open" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button">
                                            <span class="sr-only">Menu utilisateur</span>
                                            @if(auth()->user()->photoProfile)
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . auth()->user()->photoProfile) }}" alt="{{ auth()->user()->nom }}">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium">
                                                    {{ substr(auth()->user()->prenom, 0, 1) }}{{ substr(auth()->user()->nom, 0, 1) }}
                                                </div>
                                            @endif
                                        </button>
                                    </div>
                                    
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-cloak
                                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <div class="py-1">
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
                                </div>
                                
                                <div class="text-sm font-medium text-gray-700 hidden md:block">
                                    {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

            <!-- Page Content -->
        <main class="flex-1 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
            </main>

        <!-- Footer -->
        <footer class="bg-white shadow-inner">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} Système de Gestion des Congés - Tous droits réservés
                </div>
        </div>
        </footer>
    </div>
    
    @stack('scripts')
</body>

</html>
