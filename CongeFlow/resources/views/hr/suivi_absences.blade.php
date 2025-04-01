@extends('layouts.app')

@section('title', 'Suivi des absences')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Suivi des absences</h1>
        <p class="text-gray-600">Suivez les absences des salariés</p>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Calendrier des absences</h2>
            <div class="flex space-x-2">
                <div class="relative">
                    <select class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                        <option>Tous les services</option>
                        <option>Développement</option>
                        <option>Marketing</option>
                        <option>Finance</option>
                        <option>Ressources Humaines</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                <div class="relative">
                    <select class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                        <option>Juin 2023</option>
                        <option>Mai 2023</option>
                        <option>Avril 2023</option>
                        <option>Mars 2023</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap mb-4">
                <div class="flex items-center mr-4 mb-2">
                    <div class="h-4 w-4 rounded-full bg-blue-500 mr-2"></div>
                    <span class="text-sm text-gray-700">Congés payés</span>
                </div>
                <div class="flex items-center mr-4 mb-2">
                    <div class="h-4 w-4 rounded-full bg-green-500 mr-2"></div>
                    <span class="text-sm text-gray-700">RTT</span>
                </div>
                <div class="flex items-center mr-4 mb-2">
                    <div class="h-4 w-4 rounded-full bg-orange-500 mr-2"></div>
                    <span class="text-sm text-gray-700">Congé sans solde</span>
                </div>
                <div class="flex items-center mr-4 mb-2">
                    <div class="h-4 w-4 rounded-full bg-purple-500 mr-2"></div>
                    <span class="text-sm text-gray-700">Congé maladie</span>
                </div>
                <div class="flex items-center mr-4 mb-2">
                    <div class="h-4 w-4 rounded-full bg-red-500 mr-2"></div>
                    <span class="text-sm text-gray-700">Jour férié</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200 w-40">
                                Salarié
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200">
                                1
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200">
                                2
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200">
                                3
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200">
                                4
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200">
                                5
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200 bg-gray-200">
                                6
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200 bg-gray-200">
                                7
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200">
                                8
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200">
                                9
                            </th>
                            <th class="px-2 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200">
                                10
                            </th>
                            <!-- Autres jours du mois -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-b border-r border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Jean Dupont</div>
                                        <div class="text-xs text-gray-500">Développement</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200">
                                <div class="h-6 w-6 mx-auto rounded-full bg-blue-500" title="Congés payés"></div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200">
                                <div class="h-6 w-6 mx-auto rounded-full bg-blue-500" title="Congés payés"></div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200 bg-gray-100"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200 bg-gray-100"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <!-- Autres jours du mois -->
                        </tr>
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-b border-r border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/women/44.jpg" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Marie Martin</div>
                                        <div class="text-xs text-gray-500">Marketing</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200">
                                <div class="h-6 w-6 mx-auto rounded-full bg-green-500" title="RTT"></div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200 bg-gray-100"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200 bg-gray-100"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <!-- Autres jours du mois -->
                        </tr>
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-b border-r border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/67.jpg" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Pierre Durand</div>
                                        <div class="text-xs text-gray-500">Finance</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200 bg-gray-100"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200 bg-gray-100"></td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200">
                                <div class="h-6 w-6 mx-auto rounded-full bg-purple-500" title="Congé maladie"></div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200">
                                <div class="h-6 w-6 mx-auto rounded-full bg-purple-500" title="Congé maladie"></div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-sm border-b border-r border-gray-200">
                                <div class="h-6 w-6 mx-auto rounded-full bg-purple-500" title="Congé maladie"></div>
                            </td>
                            <!-- Autres jours du mois -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Statistiques d'absences</h2>
            <div class="flex space-x-2">
                <div class="relative">
                    <select class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                        <option>Année en cours</option>
                        <option>2022</option>
                        <option>2021</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-base font-medium text-gray-700 mb-4">Taux d'absence par service</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Développement</span>
                                <span class="text-sm font-medium text-gray-700">4.2%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 4.2%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Marketing</span>
                                <span class="text-sm font-medium text-gray-700">6.8%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 6.8%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Finance</span>
                                <span class="text-sm font-medium text-gray-700">3.5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 3.5%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Ressources Humaines</span>
                                <span class="text-sm font-medium text-gray-700">2.9%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 2.9%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-base font-medium text-gray-700 mb-4">Répartition par type d'absence</h3>
                <div class="bg-gray-50 p-4 rounded-lg h-64 flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-chart-pie text-4xl mb-2"></i>
                        <p>Graphique en camembert</p>
                        <p class="text-sm">Congés payés: 65%</p>
                        <p class="text-sm">RTT: 15%</p>
                        <p class="text-sm">Maladie: 12%</p>
                        <p class="text-sm">Autres: 8%</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-base font-medium text-gray-700 mb-4">Évolution mensuelle des absences</h3>
                <div class="bg-gray-50 p-4 rounded-lg h-64 flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-chart-line text-4xl mb-2"></i>
                        <p>Graphique linéaire</p>
                        <p class="text-sm">Tendance à la hausse en été</p>
                        <p class="text-sm">Pic en juillet-août</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-base font-medium text-gray-700 mb-4">Top 5 des salariés avec le plus d'absences</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="py-2 flex justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/45.jpg" alt="">
                                <span class="ml-2 text-sm font-medium text-gray-700">Thomas Petit</span>
                            </div>
                            <span class="text-sm text-gray-500">18 jours</span>
                        </li>
                        <li class="py-2 flex justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/women/22.jpg" alt="">
                                <span class="ml-2 text-sm font-medium text-gray-700">Sophie Bernard</span>
                            </div>
                            <span class="text-sm text-gray-500">15 jours</span>
                        </li>
                        <li class="py-2 flex justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/67.jpg" alt="">
                                <span class="ml-2 text-sm font-medium text-gray-700">Pierre Durand</span>
                            </div>
                            <span class="text-sm text-gray-500">12 jours</span>
                        </li>
                        <li class="py-2 flex justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/women/44.jpg" alt="">
                                <span class="ml-2 text-sm font-medium text-gray-700">Marie Martin</span>
                            </div>
                            <span class="text-sm text-gray-500">10 jours</span>
                        </li>
                        <li class="py-2 flex justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
                                <span class="ml-2 text-sm font-medium text-gray-700">Jean Dupont</span>
                            </div>
                            <span class="text-sm text-gray-500">8 jours</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

