@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mon profil</h1>
    </div>
    
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
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
    
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="bg-white shadow rounded-lg p-4 md:sticky md:top-6">
                <div class="flex flex-col items-center">
                    <div class="mb-4">
                        @if($user->photoProfile)
                            <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow" 
                                 src="{{ asset('storage/' . $user->photoProfile) }}" 
                                 alt="{{ $user->nom }}">
                        @else
                            <div class="h-32 w-32 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl border-4 border-white shadow">
                                {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->prenom }} {{ $user->nom }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <div class="mt-2 text-sm text-gray-500">
                        <p>{{ $user->poste ?? 'Poste non défini' }}</p>
                        <p>{{ $user->service ? $user->service->nom : 'Service non assigné' }}</p>
                    </div>
                    <div class="mt-3 px-3 py-1 text-xs rounded-full {{ $user->status == 'actif' ? 'bg-green-100 text-green-800' : ($user->status == 'en congé' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($user->status ?? 'Non défini') }}
                    </div>
                </div>
                
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Navigation</h3>
                    <nav class="space-y-1">
                        <a href="#informations-personnelles" 
                           class="block px-3 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-md">
                            Informations personnelles
                        </a>
                        <a href="#changer-mot-de-passe" 
                           class="block px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-md">
                            Changer mon mot de passe
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div id="informations-personnelles" class="bg-white shadow rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Informations personnelles</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Ces informations seront affichées publiquement, alors soyez prudent avec ce que vous partagez.
                        </p>
                        
                        <div class="mt-6 grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-6">
                                <label for="photoProfile" class="block text-sm font-medium text-gray-700">Photo de profil</label>
                                <div class="mt-2 flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 rounded-full overflow-hidden bg-gray-100">
                                        @if($user->photoProfile)
                                            <img class="h-16 w-16 object-cover" src="{{ asset('storage/' . $user->photoProfile) }}" alt="{{ $user->nom }}">
                                        @else
                                            <div class="h-16 w-16 rounded-full bg-blue-600 flex items-center justify-center text-white">
                                                <span class="text-xl font-medium">{{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-5 flex flex-col">
                                        <input type="file" id="photoProfile" name="photoProfile" accept="image/*" class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4 file:rounded-md
                                            file:border-0 file:text-sm file:font-medium
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100">
                                        <p class="mt-1 text-xs text-gray-500">JPG, PNG ou GIF. Max 2MB.</p>
                                        
                                        @if($user->photoProfile)
                                            <div class="mt-2">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="remove_photo" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                    <span class="ml-2 text-sm text-gray-600">Supprimer ma photo actuelle</span>
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" required>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-3">
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" required>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </form>
            
            <div id="changer-mot-de-passe" class="bg-white shadow rounded-lg">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Changer mon mot de passe</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
                        </p>
                        
                        <div class="mt-6 grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                <input type="password" name="current_password" id="current_password" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" required>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                <input type="password" name="password" id="password" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" required>
                            </div>
                            
                            <div class="col-span-6 sm:col-span-4">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 