@extends('layouts.app')

@section('title', 'Modifier un salarié')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Modifier un salarié</h1>
        <p class="text-gray-600">Modifiez les informations du salarié</p>
    </div>
    
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Erreurs de validation</p>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Informations du salarié</h2>
        </div>
        
        <form action="{{ route('hr.salaries.update', $salarie) }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Photo de profil -->
                <div class="md:col-span-2">
                    <label for="photoProfile" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0 h-24 w-24 bg-gray-100 rounded-full overflow-hidden">
                            @if($salarie->photoProfile)
                                <img class="h-24 w-24 object-cover" src="{{ asset('storage/' . $salarie->photoProfile) }}" alt="{{ $salarie->nom }}">
                            @else
                                <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 text-2xl">
                                    <span>{{ substr($salarie->prenom, 0, 1) }}{{ substr($salarie->nom, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <input type="file" id="photoProfile" name="photoProfile" accept="image/*" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4 file:rounded-md
                                file:border-0 file:text-sm file:font-medium
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100">
                            <p class="mt-1 text-sm text-gray-500">
                                JPG, PNG ou GIF. Max 1MB.
                            </p>
                            @if($salarie->photoProfile)
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="remove_photo" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Supprimer la photo actuelle</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $salarie->nom) }}" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        required>
                </div>
                
                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $salarie->prenom) }}" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        required>
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $salarie->email) }}" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        required>
                </div>
                
                <!-- Service -->
                <div>
                    <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                    <select id="service_id" name="service_id" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        required>
                        <option value="">Sélectionner un service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $salarie->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Poste -->
                <div>
                    <label for="poste" class="block text-sm font-medium text-gray-700 mb-1">Poste</label>
                    <input type="text" id="poste" name="poste" value="{{ old('poste', $salarie->poste ?? '') }}" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        required>
                </div>
                
                <!-- Date d'embauche -->
                <div>
                    <label for="date_embauche" class="block text-sm font-medium text-gray-700 mb-1">Date d'embauche</label>
                    <input type="date" id="date_embauche" name="date_embauche" value="{{ old('date_embauche', $salarie->date_embauche ? date('Y-m-d', strtotime($salarie->date_embauche)) : '') }}" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <!-- Statut -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="status" name="status" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        required>
                        <option value="actif" {{ old('status', $salarie->status) == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="en congé" {{ old('status', $salarie->status) == 'en congé' ? 'selected' : '' }}>En congé</option>
                        <option value="inactif" {{ old('status', $salarie->status) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                
                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Nouveau mot de passe <span class="text-xs text-gray-500">(laisser vide pour conserver l'actuel)</span>
                    </label>
                    <input type="password" id="password" name="password" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <!-- Confirmation de mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmer le nouveau mot de passe
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('hr.salaries.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 mr-4">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 