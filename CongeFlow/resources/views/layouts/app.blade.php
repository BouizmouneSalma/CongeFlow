<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CongeFlow - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <div x-data="{ 
        sidebarOpen: false, 
        notificationOpen: false, 
        notifications: [
            { id: 1, message: 'Votre demande de congé a été approuvée', time: 'Il y a 2 heures', read: false },
            { id: 2, message: 'Nouvelle politique de congés disponible', time: 'Il y a 1 jour', read: false },
            { id: 3, message: 'Rappel: Jour férié le 14 juillet', time: 'Il y a 2 jours', read: true }
        ]
    }">
        <!-- Sidebar -->
        <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-800 text-white transition duration-300 transform md:translate-x-0 md:static md:inset-auto md:h-screen">
            <div class="flex items-center justify-between p-4 border-b border-blue-700">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-alt text-xl"></i>
                    <span class="text-lg font-semibold">CongeFlow</span>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="mt-5 px-2">
                <div class="mb-4">
                    <p class="px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider">
                        Salarié
                    </p>
                    <a href="{{ route('employee.solde') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('employee.solde') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-wallet w-5 h-5 mr-2"></i>
                        Solde des congés
                    </a>
                    <a href="{{ route('employee.demande') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('employee.demande') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-plus-circle w-5 h-5 mr-2"></i>
                        Demande de congés
                    </a>
                    <a href="{{ route('employee.historique') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('employee.historique') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-history w-5 h-5 mr-2"></i>
                        Historique
                    </a>
                </div>
                
                <!-- HR Menu Items -->
                <div class="mb-4">
                    <p class="px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider">
                        Ressources Humaines
                    </p>
                    <a href="{{ route('hr.gestion_conges') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('hr.gestion_conges') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-tasks w-5 h-5 mr-2"></i>
                        Gestion des congés
                    </a>
                    <a href="{{ route('hr.gestion_salaries') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('hr.gestion_salaries') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-users w-5 h-5 mr-2"></i>
                        Gestion des salariés
                    </a>
                    <a href="{{ route('hr.configuration_conges') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('hr.configuration_conges') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-cog w-5 h-5 mr-2"></i>
                        Configuration
                    </a>
                    <a href="{{ route('hr.suivi_absences') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('hr.suivi_absences') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-user-clock w-5 h-5 mr-2"></i>
                        Suivi des absences
                    </a>
                </div>
                
                <!-- Admin Menu Items -->
                <div class="mb-4">
                    <p class="px-4 text-xs font-semibold text-blue-300 uppercase tracking-wider">
                        Administration
                    </p>
                    <a href="{{ route('admin.gestion_rh') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.gestion_rh') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-user-shield w-5 h-5 mr-2"></i>
                        Gestion des RH
                    </a>
                    <a href="{{ route('admin.statistiques') }}" class="mt-1 flex items-center px-4 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.statistiques') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-chart-bar w-5 h-5 mr-2"></i>
                        Statistiques
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="flex justify-between items-center px-4 py-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-1 text-gray-600 hover:text-gray-900 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
    x-text="notifications.filter(n => !n.read).length">
</span>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-cloak
                                class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-50">
                                <div class="py-2">
                                    <div class="px-4 py-2 bg-gray-100 font-medium text-gray-800 flex justify-between items-center">
                                        <span>Notifications</span>
                                        <button class="text-sm text-blue-600 hover:text-blue-800">Marquer tout comme lu</button>
                                    </div>
                                    <template x-for="notification in notifications" :key="notification.id">
                                        <div class="px-4 py-3 hover:bg-gray-50 flex" :class="{'bg-blue-50': !notification.read}">
                                            <div class="mr-3">
                                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                                    <i class="fas fa-bell"></i>
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                <div class="text-sm font-medium text-gray-900" x-text="notification.message"></div>
                                                <div class="text-xs text-gray-500" x-text="notification.time"></div>
                                            </div>
                                        </div>
                                    </template>
                                    <a href="#" class="block text-center text-sm font-medium text-blue-600 bg-gray-50 hover:bg-gray-100 py-2">
                                        Voir toutes les notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <img class="h-8 w-8 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">
                                <span class="hidden md:block text-sm font-medium text-gray-700">Jean Dupont</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-cloak
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg overflow-hidden z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Mon profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Paramètres
                                </a>
                                <div class="border-t border-gray-200"></div>
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>