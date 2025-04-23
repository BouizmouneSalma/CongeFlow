<!-- Modal de confirmation pour les actions destructives -->
<div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Confirmation</h3>
            <button class="close-modal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-6">
            <div class="mb-6">
                <p id="confirm-text" class="text-sm text-gray-700">Êtes-vous sûr de vouloir effectuer cette action ?</p>
            </div>

            <div class="flex justify-end">
                <button type="button" class="close-modal mr-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Annuler
                </button>
                <button id="confirm-button" type="button" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</div> 