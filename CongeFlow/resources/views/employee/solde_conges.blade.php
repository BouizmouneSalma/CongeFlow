@extends('layouts.app')

@section('title', 'Solde des congés')

@section('content')
<div class="bg-white overflow-hidden shadow-sm rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Solde de congés</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-50 rounded-lg p-6 border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-blue-800">Congés disponibles</h3>
                    <i class="fas fa-calendar-alt text-blue-500 text-2xl"></i>
                </div>
                <div class="text-3xl font-bold text-blue-600">
                    {{ $typesConges->where('nom', 'Congés annuels')->first()['restants'] ?? 0 }}
                </div>
                <div class="text-sm text-blue-700 mt-1">jours disponibles</div>
            </div>
            
            <div class="bg-green-50 rounded-lg p-6 border border-green-100">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-green-800">Congés pris</h3>
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                </div>
                <div class="text-3xl font-bold text-green-600">{{ $congesPris }}</div>
                <div class="text-sm text-green-700 mt-1">jours utilisés cette année</div>
            </div>
            
            <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-100">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-yellow-800">Congés en attente</h3>
                    <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                </div>
                <div class="text-3xl font-bold text-yellow-600">{{ $congesEnAttente }}</div>
                <div class="text-sm text-yellow-700 mt-1">jours en attente d'approbation</div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-800">Détail des congés par type</h3>
            </div>
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de congé</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Droits</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisés</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restants</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($typesConges as $type)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $type['nom'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $type['droits'] }} jours</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $type['pris'] }} jours</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $type['restants'] }} jours</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

