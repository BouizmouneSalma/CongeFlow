<!-- Modal pour modifier une demande -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Modifierrrrrrr la demande</h3>
            <button class="close-modal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="editForm" class="p-6">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id" name="id">
            
            <!-- Champs pour l'employé -->
       
            
            <!-- Champs pour l'admin/RH -->
            <div id="edit-admin-fields" class="hidden">
                <div class="mb-4">
                    <label for="edit-statut" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="edit-statut" name="statut" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="en_attente">En attente</option>
                        <option value="approuvee">Approuvée</option>
                        <option value="refusee">Refusée</option>
                        <option value="annulee">Annulée</option>
                    </select>
                    
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="edit-date-debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input type="date" id="edit-date-debut" name="dateDebut" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="edit-date-fin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <input type="date" id="edit-date-fin" name="dateFin" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                </div>

                     <div id="edit-employee-fields">
                <div class="mb-4">
                    <label for="edit-type" class="block text-sm font-medium text-gray-700 mb-1">Type de congé</label> 
                    <select id="edit-type" name="type_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                </div>

                <div class="mb-4">
                    <label for="edit-commentaire" class="block text-sm font-medium text-gray-700 mb-1">Commentaire (optionnel)</label>
                    <textarea id="edit-commentaire" name="commentaire" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" class="close-modal mr-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div> 