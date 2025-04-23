<!-- Modal pour créer une nouvelle demande -->
<div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Nouvelle demande de congé</h3>
            <button class="close-modal text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="createForm" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="type_id" class="block text-sm font-medium text-gray-700 mb-1">Type de congé</label>
                <select id="type_id" name="type_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="dateDebut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                    <input type="date" id="dateDebut" name="dateDebut" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="dateFin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                    <input type="date" id="dateFin" name="dateFin" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
            </div>

            <div class="mb-4">
                <label for="motif" class="block text-sm font-medium text-gray-700 mb-1">Motif (optionnel)</label>
                <textarea id="motif" name="motif" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
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