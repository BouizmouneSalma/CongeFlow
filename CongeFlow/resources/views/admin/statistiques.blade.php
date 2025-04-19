@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
<div class="bg-white overflow-hidden shadow-sm rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tableau de bord des statistiques</h2>
        
        <!-- Statistiques principales -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 rounded-lg p-6 border border-blue-100 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-blue-800">Salariés</h3>
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
                <div class="flex items-baseline space-x-2">
                    <div class="text-3xl font-bold text-blue-600">{{ $totalSalaries }}</div>
                    <div class="text-sm text-blue-700">utilisateurs</div>
                </div>
                <div class="text-xs text-blue-700 mt-2">
                    {{ round(($totalSalaries / $totalUsers) * 100) }}% des utilisateurs
                </div>
            </div>
            
            <div class="bg-green-50 rounded-lg p-6 border border-green-100 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-green-800">Responsables RH</h3>
                    <i class="fas fa-user-tie text-green-500 text-xl"></i>
                </div>
                <div class="flex items-baseline space-x-2">
                    <div class="text-3xl font-bold text-green-600">{{ $totalRH }}</div>
                    <div class="text-sm text-green-700">utilisateurs</div>
                </div>
                <div class="text-xs text-green-700 mt-2">
                    {{ round(($totalRH / $totalUsers) * 100) }}% des utilisateurs
                </div>
            </div>
            
            <div class="bg-purple-50 rounded-lg p-6 border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-purple-800">Administrateurs</h3>
                    <i class="fas fa-user-shield text-purple-500 text-xl"></i>
                </div>
                <div class="flex items-baseline space-x-2">
                    <div class="text-3xl font-bold text-purple-600">{{ $totalAdmins }}</div>
                    <div class="text-sm text-purple-700">utilisateurs</div>
                </div>
                <div class="text-xs text-purple-700 mt-2">
                    {{ round(($totalAdmins / $totalUsers) * 100) }}% des utilisateurs
                </div>
            </div>
            
            <div class="bg-red-50 rounded-lg p-6 border border-red-100 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-medium text-red-800">Demandes de congé</h3>
                    <i class="fas fa-calendar-alt text-red-500 text-xl"></i>
                </div>
                <div class="flex items-baseline space-x-2">
                    <div class="text-3xl font-bold text-red-600">{{ $totalDemandes }}</div>
                    <div class="text-sm text-red-700">demandes</div>
                </div>
                <div class="text-xs text-red-700 mt-2">
                    Moyenne: {{ $totalUsers > 0 ? round($totalDemandes / $totalUsers, 1) : 0 }} par utilisateur
                </div>
            </div>
        </div>
        
        <!-- Statistiques détaillées -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Répartition des statuts de demande -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800">Statut des demandes de congé</h3>
                </div>
                <div class="p-6">
                    @php
                        $statusClasses = [
                            'en_attente' => 'bg-yellow-100 text-yellow-800',
                            'approuvee' => 'bg-green-100 text-green-800',
                            'refusee' => 'bg-red-100 text-red-800',
                            'annulee' => 'bg-gray-100 text-gray-800',
                        ];
                        
                        $statusLabels = [
                            'en_attente' => 'En attente',
                            'approuvee' => 'Approuvée',
                            'refusee' => 'Refusée',
                            'annulee' => 'Annulée',
                        ];
                    @endphp
                    
                    @foreach($statusLabels as $status => $label)
                        <div class="mb-4 last:mb-0">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                <span class="text-sm font-medium text-gray-700">
                                    {{ $demandesParStatut[$status] ?? 0 }} 
                                    ({{ $totalDemandes > 0 ? round((($demandesParStatut[$status] ?? 0) / $totalDemandes) * 100) : 0 }}%)
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $statusClasses[$status] }} h-2.5 rounded-full" 
                                    style="width: {{ $totalDemandes > 0 ? round((($demandesParStatut[$status] ?? 0) / $totalDemandes) * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Répartition des rôles -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800">Répartition des utilisateurs</h3>
                </div>
                <div class="p-6">
                    <div class="relative" style="height: 220px;">
                        <canvas id="userRolesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Graphique des demandes par mois -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-800">Évolution des demandes de congé ({{ date('Y') }})</h3>
            </div>
            <div class="p-6">
                <div class="w-full" style="height: 300px;">
                    <canvas id="demandesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration du graphique de répartition des rôles
        const userRolesCtx = document.getElementById('userRolesChart').getContext('2d');
        const userRolesChart = new Chart(userRolesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Salariés', 'Responsables RH', 'Administrateurs'],
                datasets: [{
                    data: [{{ $totalSalaries }}, {{ $totalRH }}, {{ $totalAdmins }}],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)', // blue
                        'rgba(16, 185, 129, 0.7)', // green
                        'rgba(139, 92, 246, 0.7)'  // purple
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(139, 92, 246, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
        
        // Configuration du graphique d'évolution des demandes
        const demandesCtx = document.getElementById('demandesChart').getContext('2d');
        const demandesChart = new Chart(demandesCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($moisLabels as $mois)
                        '{{ $mois }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Nombre de demandes',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection

