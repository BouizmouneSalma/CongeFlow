@extends('layouts.app')

@section('title', 'Solde des congés')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Solde des congés</h1>
        <p class="text-gray-600">Consultez vos soldes de congés disponibles</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Congés payés -->
        <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Congés payés</h3>
                    <p class="text-sm text-gray-500">Année en cours</p>
                </div>
                <div class="bg-blue-100 rounded-full p-2">
                    <i class="fas fa-umbrella-beach text-blue-500"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-3xl font-bold text-gray-800">18</span>
                    <span class="text-sm text-gray-500">/ 25 jours</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 72%"></div>
                </div>
            </div>
        </div>
        
        <!-- RTT -->
        <div class="bg-white rounded-lg shadow p-6 border-t-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">RTT</h3>
                    <p class="text-sm text-gray-500">Année en cours</p>
                </div>
                <div class="bg-green-100 rounded-full p-2">
                    <i class="fas fa-clock text-green-500"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-3xl font-bold text-gray-800">6</span>
                    <span class="text-sm text-gray-500">/ 12 jours</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div class="bg-green-600 h-2.5 rounded-full" style="width: 50%"></div>
                </div>
            </div>
        </div>
        
        <!-- Congés exceptionnels -->
        <div class="bg-white rounded-lg shadow p-6 border-t-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Congés exceptionnels</h3>
                    <p class="text-sm text-gray-500">Événements familiaux</p>
                </div>
                <div class="bg-purple-100 rounded-full p-2">
                    <i class="fas fa-gift text-purple-500"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <span class="text-3xl font-bold text-gray-800">3</span>
                    <span class="text-sm text-gray-500">/ 3 jours</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div class="bg-purple-600 h-2.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Historique d'acquisition</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Période
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acquis
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pris
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Solde
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Janvier 2023
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Congés payés
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            2.08
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            0
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            2.08
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Février 2023
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Congés payés
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            2.08
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            1
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            3.16
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Mars 2023
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Congés payés
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            2.08
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            0
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            5.24
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Avril 2023
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            RTT
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            1
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            0
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            1
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

