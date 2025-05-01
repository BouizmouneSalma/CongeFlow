@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Gestion des congés</h2>
            <button id="newRequestBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Nouvelle demande
            </button>
        </div>
        
        <!-- Alerte de résultat d'action-->
        <div id="alertBox" class="mb-4 hidden"></div>

        <!-- Tableau des demandes -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center">
                <h3 class="text-lg font-medium text-gray-800 mb-2 sm:mb-0">Liste des demandes</h3>
                <div class="flex items-center space-x-2">
                    <select id="filterStatus" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="all">Tous les statuts</option>
                        <option value="en_attente">En attente</option>
                        <option value="approuvee">Approuvée</option>
                        <option value="refusee">Refusée</option>
                        <option value="annulee">Annulée</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="congesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if(in_array($user->role, ['admin', 'rh']))
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employé</th>
                            @endif
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="congesTableBody">
                        @foreach($demandes as $demande)
                        <tr data-id="{{ $demande->id }}" data-status="{{ $demande->statut }}">
                            @if(in_array($user->role, ['admin', 'rh']))
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $demande->user->nom }} {{ $demande->user->prenom }}
                                    </div>
                                </div>
                            </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $demande->type->libelle }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $demande->dateDebut->format('d/m/Y') }} - {{ $demande->dateFin->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $demande->duree }} jour(s)</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $demande->status_class }}">
                                    {{ $demande->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button class="viewBtn text-blue-600 hover:text-blue-900" data-id="{{ $demande->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    @if(($user->id === $demande->user_id && $demande->statut === 'en_attente') || in_array($user->role, ['admin', 'rh']))
                                    <button class="editBtn text-indigo-600 hover:text-indigo-900" data-id="{{ $demande->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endif
                                    
                                    @if($user->id === $demande->user_id && $demande->statut === 'en_attente')
                                    <button class="cancelBtn text-yellow-600 hover:text-yellow-900" data-id="{{ $demande->id }}">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                    @endif
                                    
                                    @if(in_array($user->role, ['admin', 'rh']))
                                    <button class="deleteBtn text-red-600 hover:text-red-900" data-id="{{ $demande->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('conges.partials.modal-create')
@include('conges.partials.modal-view')
@include('conges.partials.modal-edit')
@include('conges.partials.modal-confirm')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables
    const api = {
        baseUrl: '{{ url("/") }}',
        conges: '{{ route("api.conges.index") }}',
        token: '{{ csrf_token() }}'
    };
    
    // DOM Elements
    const newRequestBtn = document.getElementById('newRequestBtn');
    const filterStatus = document.getElementById('filterStatus');
    const congesTableBody = document.getElementById('congesTableBody');
    const alertBox = document.getElementById('alertBox');
    
    // Modals
    const createModal = document.getElementById('createModal');
    const viewModal = document.getElementById('viewModal');
    const editModal = document.getElementById('editModal');
    const confirmModal = document.getElementById('confirmModal');
    
    // Forms
    const createForm = document.getElementById('createForm');
    const editForm = document.getElementById('editForm');
    
    // Event Listeners
    newRequestBtn.addEventListener('click', () => {
        createModal.classList.remove('hidden');
    });
    
    filterStatus.addEventListener('change', filterDemandes);
    
    // Boutons de fermeture des modals
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', () => {
            createModal.classList.add('hidden');
            viewModal.classList.add('hidden');
            editModal.classList.add('hidden');
            confirmModal.classList.add('hidden');
        });
    });
    
    // Click sur le tableau
    congesTableBody.addEventListener('click', (e) => {
        const target = e.target.closest('button');
        if (!target) return;
        
        const id = target.dataset.id;
        
        if (target.classList.contains('viewBtn') || target.querySelector('.fa-eye')) {
            viewDemande(id);
        } else if (target.classList.contains('editBtn') || target.querySelector('.fa-edit')) {
            editDemande(id);
        } else if (target.classList.contains('cancelBtn') || target.querySelector('.fa-ban')) {
            cancelDemande(id);
        } else if (target.classList.contains('deleteBtn') || target.querySelector('.fa-trash')) {
            deleteDemande(id);
        }
    });
    
    // Soumission du formulaire de création
    createForm.addEventListener('submit', (e) => {
        e.preventDefault();
        createDemande();
    });
    
    // Soumission du formulaire d'édition
    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        updateDemande();
    });
    
    // Fonction pour filtrer les demandes par statut
    function filterDemandes() {
        const status = filterStatus.value;
        const rows = congesTableBody.querySelectorAll('tr');
        
        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }
    
    // Fonction pour afficher une alerte
    function showAlert(message, type = 'success') {
        const alertClass = type === 'success' 
            ? 'bg-green-50 border-l-4 border-green-500 text-green-700' 
            : 'bg-red-50 border-l-4 border-red-500 text-red-700';
        
        alertBox.className = `mb-4 p-4 ${alertClass}`;
        alertBox.innerHTML = message;
        alertBox.classList.remove('hidden');
        
        setTimeout(() => {
            alertBox.classList.add('hidden');
        }, 5000);
    }
    
    // Fonction pour créer une demande
    function createDemande() {
        const formData = new FormData(createForm);
        
        fetch(`${api.baseUrl}/conges`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': api.token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                let errorMessage = '<ul>';
                Object.values(data.errors).forEach(error => {
                    errorMessage += `<li>${error}</li>`;
                });
                errorMessage += '</ul>';
                
                showAlert(errorMessage, 'error');
            } else {
                createModal.classList.add('hidden');
                createForm.reset();
                showAlert(data.message);
                refreshDemandes();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Une erreur est survenue lors de la création de la demande.', 'error');
        });
    }
    
    // Fonction pour afficher les détails d'une demande
    function viewDemande(id) {
        fetch(`${api.baseUrl}/conges/${id}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': api.token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const demande = data.demande;
            
            // Remplir les détails
            document.getElementById('view-type').textContent = demande.type.libelle;
            document.getElementById('view-dates').textContent = `${formatDate(demande.dateDebut)} - ${formatDate(demande.dateFin)}`;
            document.getElementById('view-duree').textContent = `${calculateDuration(demande.dateDebut, demande.dateFin)} jour(s)`;
            document.getElementById('view-motif').textContent = demande.motif || 'Non spécifié';
            document.getElementById('view-statut').textContent = getStatusLabel(demande.statut);
            document.getElementById('view-statut').className = `px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusClass(demande.statut)}`;
            
            if (demande.commentaire) {
                document.getElementById('view-commentaire-container').classList.remove('hidden');
                document.getElementById('view-commentaire').textContent = demande.commentaire;
            } else {
                document.getElementById('view-commentaire-container').classList.add('hidden');
            }
            
            viewModal.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Une erreur est survenue lors de la récupération des détails.', 'error');
        });
    }
    
    // Fonction pour préparer l'édition d'une demande
    function editDemande(id) {
        fetch(`${api.baseUrl}/conges/${id}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': api.token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const demande = data.demande;
            const isAdmin = ['admin', 'rh'].includes('{{ $user->role }}');
            const isOwner = demande.user_id === parseInt('{{ $user->id }}');
            
            // Remplir le formulaire
            document.getElementById('edit-id').value = demande.id;
            
            if (isOwner && demande.statut === 'en_attente') {
                // Pour le propriétaire qui peut modifier sa demande
                document.getElementById('edit-employee-fields').classList.remove('hidden');
                document.getElementById('edit-admin-fields').classList.add('hidden');
                
                document.getElementById('edit-type').value = demande.type_id;
                document.getElementById('edit-date-debut').value = formatDateForInput(demande.dateDebut);
                document.getElementById('edit-date-fin').value = formatDateForInput(demande.dateFin);
                document.getElementById('edit-motif').value = demande.motif || '';
            } else if (isAdmin) {
                // Pour l'admin/RH qui peut changer le statut
                document.getElementById('edit-employee-fields').classList.add('hidden');
                document.getElementById('edit-admin-fields').classList.remove('hidden');
                
                document.getElementById('edit-statut').value = demande.statut;
                document.getElementById('edit-commentaire').value = demande.commentaire || '';
            }
            
            editModal.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Une erreur est survenue lors de la récupération des détails.', 'error');
        });
    }
    
    // Fonction pour mettre à jour une demande
    function updateDemande() {
        const id = document.getElementById('edit-id').value;
        const formData = new FormData(editForm);
        
        fetch(`${api.baseUrl}/conges/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': api.token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                let errorMessage = '<ul>';
                Object.values(data.errors).forEach(error => {
                    errorMessage += `<li>${error}</li>`;
                });
                errorMessage += '</ul>';
                
                showAlert(errorMessage, 'error');
            } else {
                editModal.classList.add('hidden');
                showAlert(data.message);
                refreshDemandes();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Une erreur est survenue lors de la mise à jour de la demande.', 'error');
        });
    }
    
    // Fonction pour annuler une demande
    function cancelDemande(id) {
        // Afficher la modale de confirmation
        document.getElementById('confirm-text').textContent = 'Êtes-vous sûr de vouloir annuler cette demande de congé ?';
        document.getElementById('confirm-button').textContent = 'Annuler la demande';
        document.getElementById('confirm-button').dataset.action = 'cancel';
        document.getElementById('confirm-button').dataset.id = id;
        
        // Event listener pour le bouton de confirmation
        document.getElementById('confirm-button').onclick = function() {
            fetch(`${api.baseUrl}/conges/${id}/cancel`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': api.token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                confirmModal.classList.add('hidden');
                showAlert(data.message);
                refreshDemandes();
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Une erreur est survenue lors de l\'annulation de la demande.', 'error');
            });
        };
        
        confirmModal.classList.remove('hidden');
    }
    
    // Fonction pour supprimer une demande
    function deleteDemande(id) {
        // Afficher la modale de confirmation
        document.getElementById('confirm-text').textContent = 'Êtes-vous sûr de vouloir supprimer définitivement cette demande de congé ?';
        document.getElementById('confirm-button').textContent = 'Supprimer';
        document.getElementById('confirm-button').dataset.action = 'delete';
        document.getElementById('confirm-button').dataset.id = id;
        
        // Event listener pour le bouton de confirmation
        document.getElementById('confirm-button').onclick = function() {
            fetch(`/api/conges/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': api.token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                confirmModal.classList.add('hidden');
                showAlert(data.message);
                refreshDemandes();
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Une erreur est survenue lors de la suppression de la demande.', 'error');
            });
        };
        
        confirmModal.classList.remove('hidden');
    }
    
    // Fonction pour rafraîchir la liste des demandes
    function refreshDemandes() {
        fetch(api.conges, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': api.token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            renderDemandes(data.demandes);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Fonction pour afficher les demandes dans le tableau
    function renderDemandes(demandes) {
        // Vider le tableau
        congesTableBody.innerHTML = '';
        
        // Si aucune demande
        if (demandes.length === 0) {
            const row = document.createElement('tr');
            const cell = document.createElement('td');
            cell.textContent = 'Aucune demande de congé trouvée.';
            cell.colSpan = '{{ in_array($user->role, ["admin", "rh"]) ? 6 : 5 }}';
            cell.className = 'px-6 py-4 text-center text-gray-500';
            row.appendChild(cell);
            congesTableBody.appendChild(row);
            return;
        }
        
        // Remplir le tableau avec les demandes
        demandes.forEach(demande => {
            const row = document.createElement('tr');
            row.dataset.id = demande.id;
            row.dataset.status = demande.statut;
            
            // Contenu de la ligne selon le rôle de l'utilisateur
            let html = '';
            
            @if(in_array($user->role, ['admin', 'rh']))
            html += `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900">
                            ${demande.user.nom} ${demande.user.prenom}
                        </div>
                    </div>
                </td>
            `;
            @endif
            
            html += `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${demande.type.libelle}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${formatDate(demande.dateDebut)} - ${formatDate(demande.dateFin)}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${calculateDuration(demande.dateDebut, demande.dateFin)} jour(s)</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusClass(demande.statut)}">
                        ${getStatusLabel(demande.statut)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-2">
                        <button class="viewBtn text-blue-600 hover:text-blue-900" data-id="${demande.id}">
                            <i class="fas fa-eye"></i>
                        </button>
            `;
            
            if (({{ $user->id }} === demande.user_id && demande.statut === 'en_attente') || {{ in_array($user->role, ['admin', 'rh']) ? 'true' : 'false' }}) {
                html += `
                    <button class="editBtn text-indigo-600 hover:text-indigo-900" data-id="${demande.id}">
                        <i class="fas fa-edit"></i>
                    </button>
                `;
            }
            
            if ({{ $user->id }} === demande.user_id && demande.statut === 'en_attente') {
                html += `
                    <button class="cancelBtn text-yellow-600 hover:text-yellow-900" data-id="${demande.id}">
                        <i class="fas fa-ban"></i>
                    </button>
                `;
            }
            
            if ({{ in_array($user->role, ['admin', 'rh']) ? 'true' : 'false' }}) {
                html += `
                    <button class="deleteBtn text-red-600 hover:text-red-900" data-id="${demande.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
            }
            
            html += `
                    </div>
                </td>
            `;
            
            row.innerHTML = html;
            congesTableBody.appendChild(row);
        });
        
        // Appliquer le filtre actuel
        filterDemandes();
    }
    
    // Fonctions utilitaires
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('fr-FR');
    }
    
    function formatDateForInput(dateString) {
        const date = new Date(dateString);
        return date.toISOString().split('T')[0];
    }
    
    function calculateDuration(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        return diffDays;
    }
    
    function getStatusClass(status) {
        const classes = {
            'en_attente': 'bg-yellow-100 text-yellow-800',
            'approuvee': 'bg-green-100 text-green-800',
            'refusee': 'bg-red-100 text-red-800',
            'annulee': 'bg-gray-100 text-gray-800'
        };
        return classes[status] || 'bg-gray-100';
    }
    
    function getStatusLabel(status) {
        const labels = {
            'en_attente': 'En attente',
            'approuvee': 'Approuvée',
            'refusee': 'Refusée',
            'annulee': 'Annulée'
        };
        return labels[status] || 'Inconnu';
    }
});
</script>
@endpush 