<!-- Modal pour afficher les détails d'une demande -->
<div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Détails de la demande</h3>
            <button class="close-modal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-6">
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">Type de congé</p>
                <p id="view-type" class="text-base font-semibold text-gray-900">-</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">Dates</p>
                <p id="view-dates" class="text-base font-semibold text-gray-900">-</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">Durée</p>
                <p id="view-duree" class="text-base font-semibold text-gray-900">-</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">Motif</p>
                <p id="view-motif" class="text-base font-semibold text-gray-900">-</p>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500">Statut</p>
                <span id="view-statut" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">-</span>
            </div>

            <div id="view-commentaire-container" class="mb-4 hidden">
                <p class="text-sm font-medium text-gray-500">Commentaire</p>
                <p id="view-commentaire" class="text-base font-semibold text-gray-900">-</p>
            </div>

            <div class="flex justify-end">
                <button type="button" class="close-modal px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div> 