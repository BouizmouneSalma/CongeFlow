@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Statistiques globales</h1>
        <p class="text-gray-600">Visualisez les statistiques globales sur les congés</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total des congés pris</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">1,248</h3>
                </div>
                <div class="bg-blue-100 rounded-full p-2">
                    <i class="fas fa-calendar-check text-blue-600"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-green-500 text-sm font-medium flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i> 12%
                    </span>
                    <span class="text-gray-500 text-sm ml-2">par rapport à l'année précédente</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Jours de congés moyens par salarié</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">24.5</h3>
                </div>
                <div class="bg-green-100 rounded-full p-2">
                    <i class="fas fa-user-clock text-green-600"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-red-500 text-sm font-medium flex items-center">
                        <i class="fas fa-arrow-down mr-1"></i> 3%
                    </span>
                    <span class="text-gray-500 text-sm ml-2">par rapport à l'année précédente</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Taux d'approbation des congés</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">92%</h3>
                </div>
                <div class="bg-purple-100 rounded-full p-2">
                    <i class="fas fa-thumbs-up text-purple-600"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-green-500 text-sm font-medium flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i> 5%
                    </span>
                    <span class="text-gray-500 text-sm ml-2">par rapport à l'année précédente</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Délai moyen d'approbation</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">1.8 j</h3>
                </div>
                <div class="bg-orange-100 rounded-full p-2">
                    <i class="fas fa-hourglass-half text-orange-600"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-green-500 text-sm font-medium flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i> 15%
                    </span>
                    <span class="text-gray-500 text-sm ml-2">plus rapide que l'année précédente</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Congés par mois</h2>
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
            <div class="p-6 h-80 flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <i class="fas fa-chart-bar text-4xl mb-2"></i>
                    <p>Graphique à barres</p>
                    <p class="text-sm">Pic en juillet-août</p>
                    <p class="text-sm">Creux en novembre-décembre</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Répartition par type de congé</h2>
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
            <div class="p-6 h-80 flex items-center justify-center">
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
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200

