@extends('layouts.app')

@section('title', 'Gestion des congés')

@section('content')
<div class="container mx-auto" id="app-gestion-conges">
    <!-- CSRF token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des congés</h1>
        <p class="text-gray-600">Approuvez ou refusez les demandes de congés des salariés</p>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Demandes de congés</h2>
            <div class="flex space-x-2">
                <div class="relative">
                    <select id="filter-service" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                        <option value="">Tous les services</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                <div class="relative">
                    <select id="filter-type" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                        <option value="">Tous les types</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->nom }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                <div class="relative">
                    <select id="filter-statut" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                        <option value="">Tous les statuts</option>
                        @foreach($statuts as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                <div class="relative">
                    <input type="text" id="search-salarie" placeholder="Rechercher un salarié" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Salarié
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Service
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Période
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Durée
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date de demande
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="demandes-list">
                    @php
                        // Combiner toutes les demandes pour l'affichage initial
                        $toutesLesDemandes = $demandesEnAttente->merge($demandesTraitees);
                    @endphp
                    
                    @foreach($toutesLesDemandes as $demande)
                    <tr data-demande-id="{{ $demande->id }}" 
                        data-type-id="{{ $demande->type_id }}" 
                        data-service-id="{{ $demande->user->service_id ?? '' }}" 
                        data-statut="{{ $demande->statut }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($demande->user->name ?? 'User') }}&background=random" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $demande->user->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $demande->user->email ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $demande->user->service->nom ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $demande->type->nom ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($demande->dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($demande->dateFin)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($demande->dateDebut)->diffInDays(\Carbon\Carbon::parse($demande->dateFin)) + 1 }} jours
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($demande->statut == 'approuvee')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Approuvée
                                </span>
                            @elseif($demande->statut == 'refusee')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Refusée
                                </span>
                            @elseif($demande->statut == 'en_attente')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    En attente
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($demande->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                @if($demande->statut == 'en_attente')
                                <button 
                                    class="btn-approve inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150"
                                    data-demande-id="{{ $demande->id }}"
                                    title="Approuver cette demande"
                                >
                                    <i class="fas fa-check mr-1"></i> Approuver
                                </button>
                                <button 
                                    class="btn-refuse inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150"
                                    data-demande-id="{{ $demande->id }}"
                                    title="Refuser cette demande"
                                >
                                    <i class="fas fa-times mr-1"></i> Refuser
                                </button>
                                @endif
                                <button 
                                    class="btn-details inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150"
                                    data-demande-id="{{ $demande->id }}"
                                    title="Voir les détails"
                                >
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(count($toutesLesDemandes) == 0)
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Aucune demande trouvée
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700" id="demandes-counter">
                Affichage de <span class="font-medium">{{ count($toutesLesDemandes) > 0 ? 1 : 0 }}</span> à <span class="font-medium">{{ count($toutesLesDemandes) }}</span> sur <span class="font-medium">{{ count($toutesLesDemandes) }}</span> résultats
            </div>
            <div class="flex space-x-2">
                <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Précédent
                </button>
                <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Suivant
                </button>
            </div>
        </div>
    </div>
    
    <!-- Modal pour les détails de la demande -->
    <div id="details-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full transform transition-transform duration-300 scale-90">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Détails de la demande</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div id="modal-content" class="space-y-4">
                    <!-- Le contenu sera injecté ici dynamiquement -->
                    <div class="animate-pulse flex space-x-4">
                        <div class="flex-1 space-y-4 py-1">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-200 rounded"></div>
                                <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-between">
                    <div>
                        <button id="modal-reject" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i> Refuser
                        </button>
                    </div>
                    <div>
                        <button id="modal-close" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2 transition-colors duration-200">
                            Fermer
                        </button>
                        <button id="modal-approve" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-check mr-2"></i> Approuver
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal pour refus avec commentaire -->
    <div id="refus-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full transform transition-transform duration-300 scale-90">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Motif de refus</h3>
                <button id="close-refus-modal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <input type="hidden" id="refus-demande-id">
                <div class="mb-4">
                    <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-1">Commentaire (optionnel)</label>
                    <textarea id="commentaire" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Précisez la raison du refus..."></textarea>
                    <p class="mt-1 text-xs text-gray-500">Utilisez Ctrl+Entrée pour confirmer le refus rapidement.</p>
                </div>
                <div class="flex justify-end">
                    <button id="cancel-refus" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2 transition-colors duration-200">
                        Annuler
                    </button>
                    <button id="confirm-refus" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <i class="fas fa-ban mr-2"></i> Confirmer le refus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    let currentDemandeId = null;
    let currentDemandeStatut = null;
    
    // Filtrage des demandes
    const filterService = document.getElementById('filter-service');
    const filterType = document.getElementById('filter-type');
    const filterStatut = document.getElementById('filter-statut');
    const searchSalarie = document.getElementById('search-salarie');
    
    function applyFilters() {
        const serviceValue = filterService.value;
        const typeValue = filterType.value;
        const statutValue = filterStatut.value;
        const searchValue = searchSalarie.value.toLowerCase();
        
        const rows = document.querySelectorAll('#demandes-list tr[data-demande-id]');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const serviceId = row.getAttribute('data-service-id');
            const typeId = row.getAttribute('data-type-id');
            const statut = row.getAttribute('data-statut');
            const salarieName = row.querySelector('.text-sm.font-medium.text-gray-900').textContent.toLowerCase();
            
            const matchService = !serviceValue || serviceId === serviceValue;
            const matchType = !typeValue || typeId === typeValue;
            const matchStatut = !statutValue || statut === statutValue;
            const matchSearch = !searchValue || salarieName.includes(searchValue);
            
            if (matchService && matchType && matchStatut && matchSearch) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Mettre à jour le compteur
        updateCounter(visibleCount, rows.length);
    }
    
    function updateCounter(visible, total) {
        const counter = document.getElementById('demandes-counter');
        if (counter) {
            counter.innerHTML = `Affichage de <span class="font-medium">${visible > 0 ? 1 : 0}</span> à <span class="font-medium">${visible}</span> sur <span class="font-medium">${total}</span> résultats`;
        }
    }
    
    filterService.addEventListener('change', applyFilters);
    filterType.addEventListener('change', applyFilters);
    filterStatut.addEventListener('change', applyFilters);
    searchSalarie.addEventListener('input', applyFilters);
    
    // Manipuler les boutons d'approbation/refus
    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.addEventListener('click', function() {
            const demandeId = this.getAttribute('data-demande-id');
            
            // Demander confirmation avant d'approuver
            if (confirm('Êtes-vous sûr de vouloir approuver cette demande de congé ?')) {
                updateDemandeStatus(demandeId, 'approuvee');
                
                // Feedback visuel
                showNotification('Demande approuvée avec succès', 'success');
            }
        });
    });
    
    document.querySelectorAll('.btn-refuse').forEach(btn => {
        btn.addEventListener('click', function() {
            const demandeId = this.getAttribute('data-demande-id');
            showRefusModal(demandeId);
        });
    });
    
    document.querySelectorAll('.btn-details').forEach(btn => {
        btn.addEventListener('click', function() {
            const demandeId = this.getAttribute('data-demande-id');
            showDetailsModal(demandeId);
        });
    });
    
    function updateDemandeStatus(demandeId, status, commentaire = '') {
        // Simuler un spinner ou une indication de chargement
        const row = document.querySelector(`tr[data-demande-id="${demandeId}"]`);
        if (row) {
            row.classList.add('opacity-50');
            
            // Ajouter un spinner dans la cellule des actions
            const actionCell = row.querySelector('td:last-child');
            if (actionCell) {
                const originalContent = actionCell.innerHTML;
                actionCell.innerHTML = `<div class="flex justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>`;
            }
        }
        
        // URL et données pour la requête AJAX
        let url = '';
        let data = {};
        
        if (status === 'approuvee') {
            url = `/conges/${demandeId}/approve`;
            data = {};
        } else if (status === 'refusee') {
            url = `/conges/${demandeId}/reject`;
            data = { motif_refus: commentaire };
        }
        
        // Appel AJAX pour mettre à jour le statut
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            // Mise à jour réussie, on rafraîchit les données
            showNotification(data.message || 'Demande mise à jour avec succès', 'success');
            refreshData();
        })
        .catch(error => {
            console.error('Erreur lors de la mise à jour:', error);
            if (row) {
                row.classList.remove('opacity-50');
                if (actionCell && originalContent) {
                    actionCell.innerHTML = originalContent;
                }
            }
            showNotification('Une erreur est survenue lors de la mise à jour de la demande.', 'error');
        });
    }
    
    function refreshData() {
        fetch('/api/conges')
            .then(response => response.json())
            .then(data => {
                // Animation de rafraîchissement avant le rechargement
                document.querySelectorAll('#demandes-list tr').forEach(tr => {
                    tr.classList.add('transition-opacity', 'duration-500', 'opacity-0');
                });
                
                // Attendre la fin de l'animation avant de recharger
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            })
            .catch(error => {
                console.error('Erreur lors du rafraîchissement des données:', error);
                showNotification('Erreur lors du rafraîchissement des données', 'error');
            });
    }
    
    function showDetailsModal(demandeId) {
        currentDemandeId = demandeId;
        
        // Animation d'ouverture du modal
        const modal = document.getElementById('details-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.bg-white').classList.add('scale-100');
            modal.querySelector('.bg-white').classList.remove('scale-90');
        }, 10);
        
        // Charger les détails de la demande
        fetch(`/conges/${demandeId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            const demande = data.demande;
            const dateDebut = new Date(demande.dateDebut).toLocaleDateString('fr-FR');
            const dateFin = new Date(demande.dateFin).toLocaleDateString('fr-FR');
            const dateCreation = new Date(demande.created_at).toLocaleDateString('fr-FR');
            currentDemandeStatut = demande.statut;
            
            let duree = Math.ceil((new Date(demande.dateFin) - new Date(demande.dateDebut)) / (1000 * 60 * 60 * 24)) + 1;
            
            // Afficher ou masquer les boutons d'action selon le statut
            const modalApprove = document.getElementById('modal-approve');
            const modalReject = document.getElementById('modal-reject');
            
            if (demande.statut === 'en_attente') {
                modalApprove.classList.remove('hidden');
                modalReject.classList.remove('hidden');
            } else {
                modalApprove.classList.add('hidden');
                modalReject.classList.add('hidden');
            }
            
            // Formater le contenu du modal avec des transitions
            const modalContent = document.getElementById('modal-content');
            modalContent.innerHTML = `<div class="animate-pulse bg-gray-100 rounded-lg h-40"></div>`;
            
            setTimeout(() => {
                modalContent.innerHTML = `
                    <div class="grid grid-cols-2 gap-4 animate-fade-in">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Salarié</p>
                            <p class="text-sm font-bold text-gray-900">${demande.user.name}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="text-sm text-gray-900">${demande.user.email}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Service</p>
                            <p class="text-sm text-gray-900">${demande.user.service ? demande.user.service.nom : 'Non spécifié'}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Type de congé</p>
                            <p class="text-sm text-gray-900">${demande.type.nom}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date de début</p>
                            <p class="text-sm text-gray-900">${dateDebut}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date de fin</p>
                            <p class="text-sm text-gray-900">${dateFin}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Durée</p>
                            <p class="text-sm text-gray-900">${duree} jour${duree > 1 ? 's' : ''}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Statut</p>
                            <p class="text-sm text-gray-900 ${getStatutColorClass(demande.statut)}">${getStatutLabel(demande.statut)}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date de demande</p>
                            <p class="text-sm text-gray-900">${dateCreation}</p>
                        </div>
                        ${demande.commentaire ? `
                        <div class="col-span-2">
                            <p class="text-sm font-medium text-gray-500">Commentaire</p>
                            <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">${demande.commentaire}</p>
                        </div>` : ''}
                        ${demande.motif_refus ? `
                        <div class="col-span-2">
                            <p class="text-sm font-medium text-gray-500">Motif de refus</p>
                            <p class="text-sm text-gray-900 bg-red-50 p-2 rounded border border-red-100">${demande.motif_refus}</p>
                        </div>` : ''}
                    </div>
                    ${demande.motif ? `
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-500">Motif</p>
                        <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded">${demande.motif}</p>
                    </div>` : ''}
                `;
            }, 300);
        })
        .catch(error => {
            console.error('Erreur lors du chargement des détails:', error);
            document.getElementById('modal-content').innerHTML = `
                <div class="text-center text-red-500">
                    <p>Une erreur est survenue lors du chargement des détails.</p>
                </div>
            `;
        });
    }
    
    function getStatutColorClass(statut) {
        const colors = {
            'en_attente': 'text-yellow-600',
            'approuvee': 'text-green-600',
            'refusee': 'text-red-600',
            'annulee': 'text-gray-600'
        };
        
        return colors[statut] || '';
    }
    
    function getStatutLabel(statut) {
        const labels = {
            'en_attente': 'En attente',
            'approuvee': 'Approuvée',
            'refusee': 'Refusée',
            'annulee': 'Annulée'
        };
        
        return labels[statut] || statut;
    }
    
    function showRefusModal(demandeId) {
        document.getElementById('refus-demande-id').value = demandeId;
        document.getElementById('commentaire').value = '';
        
        // Animation d'ouverture
        const modal = document.getElementById('refus-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.bg-white').classList.add('scale-100');
            modal.querySelector('.bg-white').classList.remove('scale-90');
        }, 10);
        
        // Focus sur le champ commentaire
        setTimeout(() => {
            document.getElementById('commentaire').focus();
        }, 300);
    }
    
    // Gérer les boutons du modal de détails
    document.getElementById('close-modal').addEventListener('click', function() {
        closeDetailsModal();
    });
    
    document.getElementById('modal-close').addEventListener('click', function() {
        closeDetailsModal();
    });
    
    function closeDetailsModal() {
        const modal = document.getElementById('details-modal');
        modal.querySelector('.bg-white').classList.remove('scale-100');
        modal.querySelector('.bg-white').classList.add('scale-90');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    
    document.getElementById('modal-approve').addEventListener('click', function() {
        if (currentDemandeId) {
            if (currentDemandeStatut === 'en_attente') {
                updateDemandeStatus(currentDemandeId, 'approuvee');
                closeDetailsModal();
                showNotification('Demande approuvée avec succès', 'success');
            }
        }
    });
    
    document.getElementById('modal-reject').addEventListener('click', function() {
        if (currentDemandeId) {
            closeDetailsModal();
            showRefusModal(currentDemandeId);
        }
    });
    
    // Gérer les boutons du modal de refus
    document.getElementById('close-refus-modal').addEventListener('click', function() {
        closeRefusModal();
    });
    
    document.getElementById('cancel-refus').addEventListener('click', function() {
        closeRefusModal();
    });
    
    document.getElementById('confirm-refus').addEventListener('click', function() {
        const demandeId = document.getElementById('refus-demande-id').value;
        const commentaire = document.getElementById('commentaire').value;
        
        if (demandeId) {
            if (!commentaire.trim()) {
                if (!confirm('Voulez-vous vraiment refuser cette demande sans ajouter de commentaire ?')) {
                    return;
                }
            }
            
            // Désactiver le bouton pendant la soumission
            const button = this;
            button.disabled = true;
            button.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Traitement en cours...';
            
            updateDemandeStatus(demandeId, 'refusee', commentaire);
            closeRefusModal();
            
            // Réactiver le bouton après un délai
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-ban mr-2"></i> Confirmer le refus';
            }, 2000);
        }
    });
    
    function closeRefusModal() {
        const modal = document.getElementById('refus-modal');
        modal.querySelector('.bg-white').classList.remove('scale-100');
        modal.querySelector('.bg-white').classList.add('scale-90');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    
    // Ajout d'une notification temporaire
    function showNotification(message, type = 'info') {
        // Créer l'élément de notification
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-500 transform translate-x-full opacity-0 flex items-center ${getNotificationClass(type)}`;
        
        // Ajouter l'icône correspondante au type
        let icon = '';
        if (type === 'success') {
            icon = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>';
        } else if (type === 'error') {
            icon = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';
        } else if (type === 'warning') {
            icon = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
        } else {
            icon = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';
        }
        
        notification.innerHTML = icon + message;
        
        // Ajouter au document
        document.body.appendChild(notification);
        
        // Animer l'entrée
        setTimeout(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 10);
        
        // Animer la sortie après 3s
        setTimeout(() => {
            notification.classList.remove('translate-x-0', 'opacity-100');
            notification.classList.add('translate-x-full', 'opacity-0');
            
            // Supprimer du DOM après l'animation
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        }, 3000);
    }
    
    function getNotificationClass(type) {
        const classes = {
            'success': 'bg-green-600 text-white',
            'error': 'bg-red-600 text-white',
            'warning': 'bg-yellow-500 text-white',
            'info': 'bg-blue-500 text-white'
        };
        
        return classes[type] || classes.info;
    }
    
    // Ajout des écouteurs pour les touches du clavier dans les modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (!document.getElementById('details-modal').classList.contains('hidden')) {
                closeDetailsModal();
            }
            if (!document.getElementById('refus-modal').classList.contains('hidden')) {
                closeRefusModal();
            }
        }
        
        if (e.key === 'Enter' && !document.getElementById('refus-modal').classList.contains('hidden') && e.ctrlKey) {
            document.getElementById('confirm-refus').click();
        }
    });
    
    // Add specific functions for approving and rejecting requests if they don't exist
    function approveRequest(demandeId) {
        if (confirm('Êtes-vous sûr de vouloir approuver cette demande de congé ?')) {
            updateDemandeStatus(demandeId, 'approuvee');
            showNotification('Demande approuvée avec succès', 'success');
        }
    }
    
    function rejectRequest(demandeId) {
        showRefusModal(demandeId);
    }
    
    // Add event listeners for the approve and reject buttons if not already present
    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.addEventListener('click', function() {
            const demandeId = this.getAttribute('data-demande-id');
            approveRequest(demandeId);
        });
    });
    
    document.querySelectorAll('.btn-refuse').forEach(btn => {
        btn.addEventListener('click', function() {
            const demandeId = this.getAttribute('data-demande-id');
            rejectRequest(demandeId);
        });
    });
    
    // Enhance the existing filterDemandes function
    function filterDemandes() {
        const serviceValue = filterService.value;
        const typeValue = filterType.value;
        const statutValue = filterStatut.value;
        const searchValue = searchSalarie.value.toLowerCase();
        
        fetch('/api/conges/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                service_id: serviceValue,
                type_id: typeValue,
                statut: statutValue,
                search: searchValue
            })
        })
        .then(response => response.json())
        .then(data => {
            renderDemandesTable(data.demandes);
        })
        .catch(error => {
            console.error('Erreur lors du filtrage des demandes:', error);
            applyFilters(); // Fallback to client-side filtering
        });
    }
    
    // Function to render the table with filtered data
    function renderDemandesTable(demandes) {
        const tableBody = document.getElementById('demandes-list');
        
        if (!tableBody) return;
        
        if (demandes.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                        Aucune demande trouvée
                    </td>
                </tr>
            `;
            updateCounter(0, 0);
            return;
        }
        
        let html = '';
        
        demandes.forEach(demande => {
            const dateDebut = new Date(demande.dateDebut).toLocaleDateString('fr-FR');
            const dateFin = new Date(demande.dateFin).toLocaleDateString('fr-FR');
            const dateCreation = new Date(demande.created_at).toLocaleDateString('fr-FR');
            
            let duree = Math.ceil((new Date(demande.dateFin) - new Date(demande.dateDebut)) / (1000 * 60 * 60 * 24)) + 1;
            
            html += `
                <tr data-demande-id="${demande.id}" 
                    data-type-id="${demande.type_id}" 
                    data-service-id="${demande.user?.service_id || ''}" 
                    data-statut="${demande.statut}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=${encodeURIComponent(demande.user?.name || 'User')}&background=random" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${demande.user?.name || 'N/A'}</div>
                                <div class="text-sm text-gray-500">${demande.user?.email || 'N/A'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${demande.user?.service?.nom || 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            ${demande.type?.nom || 'N/A'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${dateDebut} - ${dateFin}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${duree} jours
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        ${formatStatus(demande.statut)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${dateCreation}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            ${demande.statut === 'en_attente' ? `
                                <button 
                                    class="btn-approve inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150"
                                    data-demande-id="${demande.id}"
                                    title="Approuver cette demande"
                                >
                                    <i class="fas fa-check mr-1"></i> Approuver
                                </button>
                                <button 
                                    class="btn-refuse inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150"
                                    data-demande-id="${demande.id}"
                                    title="Refuser cette demande"
                                >
                                    <i class="fas fa-times mr-1"></i> Refuser
                                </button>
                            ` : ''}
                            <button 
                                class="btn-details inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150"
                                data-demande-id="${demande.id}"
                                title="Voir les détails"
                            >
                                <i class="fas fa-eye mr-1"></i> Détails
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        tableBody.innerHTML = html;
        updateCounter(demandes.length, demandes.length);
        
        // Reattach event listeners
        attachActionListeners();
    }
    
    function formatStatus(statut) {
        if (statut === 'approuvee') {
            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Approuvée
                </span>`;
        } else if (statut === 'refusee') {
            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    Refusée
                </span>`;
        } else if (statut === 'en_attente') {
            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    En attente
                </span>`;
        } else {
            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    ${statut.charAt(0).toUpperCase() + statut.slice(1).replace('_', ' ')}
                </span>`;
        }
    }
    
    function attachActionListeners() {
        // Attach event listeners to newly rendered buttons
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.addEventListener('click', function() {
                const demandeId = this.getAttribute('data-demande-id');
                approveRequest(demandeId);
            });
        });
        
        document.querySelectorAll('.btn-refuse').forEach(btn => {
            btn.addEventListener('click', function() {
                const demandeId = this.getAttribute('data-demande-id');
                rejectRequest(demandeId);
            });
        });
        
        document.querySelectorAll('.btn-details').forEach(btn => {
            btn.addEventListener('click', function() {
                const demandeId = this.getAttribute('data-demande-id');
                showDetailsModal(demandeId);
            });
        });
    }
    
    // Replace the existing applyFilters function with a call to filterDemandes
    filterService.addEventListener('change', filterDemandes);
    filterType.addEventListener('change', filterDemandes);
    filterStatut.addEventListener('change', filterDemandes);
    searchSalarie.addEventListener('input', filterDemandes);
});
</script>

<style>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.scale-90 {
    transform: scale(0.9);
}

.scale-100 {
    transform: scale(1);
}

.transition-transform {
    transition-property: transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>
@endsection

