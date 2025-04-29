{{-- 
    Boutons de décision (approuver/refuser) - Composant réutilisable
    Usage: @include('includes.decision_buttons', ['demande' => $demande])
--}}

<div class="decision-buttons-container mb-4" data-demande-id="{{ $demande->id ?? '' }}">
    <div class="flex items-center space-x-4">
        <!-- Bouton Approuver -->
        <button 
            type="button" 
            class="btn-approve inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            onclick="approuverDemande('{{ $demande->id ?? '' }}')"
        >
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Approuver
        </button>

        <!-- Bouton Refuser -->
        <button 
            type="button" 
            class="btn-refuse inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            onclick="refuserDemande('{{ $demande->id ?? '' }}')"
        >
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Refuser
        </button>
    </div>

    <!-- Formulaire caché pour soumettre la décision -->
    <form id="form-decision-{{ $demande->id ?? 'default' }}" action="{{ route('update-statut', ['id' => $demande->id ?? '']) }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="statut" id="decision-{{ $demande->id ?? 'default' }}">
        <input type="hidden" name="commentaire" id="motif-refus-{{ $demande->id ?? 'default' }}">
    </form>
</div>

<!-- Modal pour le motif de refus -->
<div id="modal-refus-{{ $demande->id ?? 'default' }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Motif du refus</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500" onclick="fermerModalRefus('{{ $demande->id ?? 'default' }}')">
                <span class="sr-only">Fermer</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div>
            <label for="textarea-motif-{{ $demande->id ?? 'default' }}" class="block text-sm font-medium text-gray-700 mb-2">
                Veuillez indiquer le motif du refus
            </label>
            <textarea 
                id="textarea-motif-{{ $demande->id ?? 'default' }}" 
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" 
                rows="4"
                placeholder="Saisissez le motif du refus..."
            ></textarea>
        </div>
        <div class="mt-5 sm:mt-6 flex justify-end space-x-3">
            <button 
                type="button" 
                class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                onclick="fermerModalRefus('{{ $demande->id ?? 'default' }}')"
            >
                Annuler
            </button>
            <button 
                type="button" 
                class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                onclick="confirmerRefus('{{ $demande->id ?? 'default' }}')"
            >
                Confirmer le refus
            </button>
        </div>
    </div>
</div>

<!-- Toast de notification -->
<div id="toast-notification" class="fixed top-4 right-4 max-w-xs bg-white border border-gray-100 rounded-lg shadow-lg transform transition-transform duration-300 translate-y-[-100%] opacity-0 z-50 hidden">
    <div class="p-4">
        <div class="flex items-start">
            <div id="toast-icon" class="flex-shrink-0">
                <!-- L'icône sera insérée dynamiquement -->
            </div>
            <div class="ml-3 w-0 flex-1">
                <p id="toast-message" class="text-sm font-medium text-gray-900">
                    <!-- Le message sera inséré dynamiquement -->
                </p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button type="button" class="inline-flex text-gray-400 hover:text-gray-500" onclick="fermerToast()">
                    <span class="sr-only">Fermer</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour approuver directement une demande
    function approuverDemande(demandeId) {
        if (confirm('Êtes-vous sûr de vouloir approuver cette demande ?')) {
            const form = document.getElementById(`form-decision-${demandeId}`);
            document.getElementById(`decision-${demandeId}`).value = 'approuvee';
            
            // Soumission AJAX du formulaire
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Masquer les boutons
                document.querySelector(`.decision-buttons-container[data-demande-id="${demandeId}"]`).style.display = 'none';
                
                // Mettre à jour l'affichage du statut si nécessaire
                updateStatutDisplay(demandeId, 'approuvee');
                
                // Afficher une notification
                afficherToast('success', data.message || 'Demande approuvée avec succès');
            })
            .catch(error => {
                console.error('Erreur:', error);
                afficherToast('error', 'Une erreur est survenue lors du traitement de votre demande.');
            });
        }
    }

    // Fonction pour ouvrir le modal de refus
    function refuserDemande(demandeId) {
        document.getElementById(`modal-refus-${demandeId}`).classList.remove('hidden');
        document.getElementById(`textarea-motif-${demandeId}`).focus();
    }

    // Fonction pour fermer le modal de refus
    function fermerModalRefus(demandeId) {
        document.getElementById(`modal-refus-${demandeId}`).classList.add('hidden');
    }

    // Fonction pour confirmer le refus
    function confirmerRefus(demandeId) {
        const motif = document.getElementById(`textarea-motif-${demandeId}`).value.trim();
        
        if (!motif) {
            alert('Veuillez saisir un motif de refus.');
            return;
        }
        
        const form = document.getElementById(`form-decision-${demandeId}`);
        document.getElementById(`decision-${demandeId}`).value = 'refusee';
        document.getElementById(`motif-refus-${demandeId}`).value = motif;
        
        // Soumission AJAX du formulaire
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Fermer le modal
            fermerModalRefus(demandeId);
            
            // Masquer les boutons
            document.querySelector(`.decision-buttons-container[data-demande-id="${demandeId}"]`).style.display = 'none';
            
            // Mettre à jour l'affichage du statut si nécessaire
            updateStatutDisplay(demandeId, 'refusee');
            
            // Afficher une notification
            afficherToast('success', data.message || 'Demande refusée avec succès');
        })
        .catch(error => {
            console.error('Erreur:', error);
            fermerModalRefus(demandeId);
            afficherToast('error', 'Une erreur est survenue lors du traitement de votre demande.');
        });
    }
    
    // Fonction pour mettre à jour l'affichage du statut
    function updateStatutDisplay(demandeId, statut) {
        // Recherchez l'élément qui affiche le statut pour cette demande
        const statutElements = document.querySelectorAll(`[data-statut-demande-id="${demandeId}"]`);
        
        statutElements.forEach(el => {
            // Supprimez les classes existantes
            el.classList.remove('bg-yellow-100', 'text-yellow-800', 'bg-green-100', 'text-green-800', 'bg-red-100', 'text-red-800');
            
            // Ajoutez les nouvelles classes selon le statut
            if (statut === 'approuvee') {
                el.classList.add('bg-green-100', 'text-green-800');
                el.textContent = 'Approuvée';
            } else if (statut === 'refusee') {
                el.classList.add('bg-red-100', 'text-red-800');
                el.textContent = 'Refusée';
            }
        });
    }

    // Fonction pour afficher le toast de notification
    function afficherToast(type, message) {
        const toast = document.getElementById('toast-notification');
        const toastIcon = document.getElementById('toast-icon');
        const toastMessage = document.getElementById('toast-message');
        
        // Définir l'icône selon le type
        if (type === 'success') {
            toastIcon.innerHTML = `
                <svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            `;
        } else {
            toastIcon.innerHTML = `
                <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            `;
        }
        
        // Définir le message
        toastMessage.textContent = message;
        
        // Afficher le toast
        toast.classList.remove('hidden', 'translate-y-[-100%]', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        
        // Masquer le toast après 5 secondes
        setTimeout(() => {
            fermerToast();
        }, 5000);
    }
    
    // Fonction pour fermer le toast
    function fermerToast() {
        const toast = document.getElementById('toast-notification');
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-[-100%]', 'opacity-0');
        
        // Attendre la fin de l'animation pour cacher l'élément
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 300);
    }
</script> 