@extends('layouts.app')

@section('title', 'Demande de congés')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Demande de congés</h1>
        <p class="text-gray-600">Remplissez le formulaire pour soumettre une demande de congés</p>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="#" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="type_conge" class="block text-sm font-medium text-gray-700 mb-1">Type de congé</label>
                        <select id="type_conge" name="type_conge" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Sélectionnez un type de congé</option>
                            <option value="cp">Congés payés</option>
                            <option value="rtt">RTT</option>
                            <option value="sans_solde">Congé sans solde</option>
                            <option value="maladie">Congé maladie</option>
                            <option value="exceptionnel">Congé exceptionnel</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="motif" class="block text-sm font-medium text-gray-700 mb-1">Motif (optionnel)</label>
                        <input type="text" id="motif" name="motif" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    
                    <div>
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="heure_debut" class="block text-sm font-medium text-gray-700 mb-1">Heure de début (si demi-journée)</label>
                        <select id="heure_debut" name="heure_debut" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Journée complète</option>
                            <option value="matin">Matin</option>
                            <option value="apres_midi">Après-midi</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="heure_fin" class="block text-sm font-medium text-gray-700 mb-1">Heure de fin (si demi-journée)</label>
                        <select id="heure_fin" name="heure_fin" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Journée complète</option>
                            <option value="matin">Matin</option>
                            <option value="apres_midi">Après-midi</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-1">Commentaire (optionnel)</label>
                    <textarea id="commentaire" name="commentaire" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-md mb-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="confirmation" name="confirmation" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="confirmation" class="font-medium text-gray-700">Je confirme que ces informations sont correctes</label>
                            <p class="text-gray-500">Une notification sera envoyée à votre responsable pour validation.</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Annuler
                    </button>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Soumettre la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Solde disponible</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-2">
                            <i class="fas fa-umbrella-beach text-blue-500"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-blue-800">Congés payés</h3>
                            <p class="text-xl font-semibold text-blue-900">18 jours</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-2">
                            <i class="fas fa-clock text-green-500"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-green-800">RTT</h3>
                            <p class="text-xl font-semibold text-green-900">6 jours</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 p-4 rounded-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-md p-2">
                            <i class="fas fa-gift text-purple-500"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-purple-800">Congés exceptionnels</h3>
                            <p class="text-xl font-semibold text-purple-900">3 jours</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

