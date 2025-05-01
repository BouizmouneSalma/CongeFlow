@extends('layouts.app')

@section('title', 'Test d\'upload de photo')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Test d'upload de photo</h1>
        <p class="text-gray-600">Utilisez ce formulaire pour tester l'upload de photos</p>
    </div>
    
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
            @if (session('photo'))
                <div class="mt-4">
                    <p class="font-semibold">Photo chargée :</p>
                    <img src="{{ asset('storage/' . session('photo')) }}" alt="Uploaded" class="mt-2 h-32 w-32 object-cover">
                    <p class="mt-2 text-sm">Chemin : {{ session('photo') }}</p>
                    <p class="text-sm">URL : {{ asset('storage/' . session('photo')) }}</p>
                </div>
            @endif
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
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
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Formulaire d'upload</h2>
        </div>
        
        <form action="{{ route('test.upload') }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                <input type="file" id="photo" name="photo" accept="image/*" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4 file:rounded-md
                    file:border-0 file:text-sm file:font-medium
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100" required>
                <p class="mt-1 text-sm text-gray-500">
                    JPG, PNG ou GIF. Max 2MB.
                </p>
            </div>
            
            <div class="flex items-center justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-upload mr-2"></i> Télécharger
                </button>
            </div>
        </form>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Informations de débogage</h2>
        </div>
        
        <div class="p-6">
            <h3 class="text-md font-semibold mb-2">Chemins de stockage</h3>
            <ul class="list-disc pl-5 mb-4">
                <li>Chemin public : <code class="bg-gray-100 px-1 py-0.5 rounded">{{ public_path() }}</code></li>
                <li>Chemin de stockage : <code class="bg-gray-100 px-1 py-0.5 rounded">{{ storage_path() }}</code></li>
                <li>Lien symbolique : <code class="bg-gray-100 px-1 py-0.5 rounded">{{ public_path('storage') }}</code> 
                    @if(file_exists(public_path('storage')))
                        <span class="text-green-500">(✓ Existe)</span>
                    @else
                        <span class="text-red-500">(✗ N'existe pas)</span>
                    @endif
                </li>
                <li>Dossier test-uploads : <code class="bg-gray-100 px-1 py-0.5 rounded">{{ storage_path('app/public/test-uploads') }}</code>
                    @if(file_exists(storage_path('app/public/test-uploads')))
                        <span class="text-green-500">(✓ Existe)</span>
                    @else
                        <span class="text-red-500">(✗ N'existe pas)</span>
                    @endif
                </li>
                <li>Dossier profile-photos : <code class="bg-gray-100 px-1 py-0.5 rounded">{{ storage_path('app/public/profile-photos') }}</code>
                    @if(file_exists(storage_path('app/public/profile-photos')))
                        <span class="text-green-500">(✓ Existe)</span>
                    @else
                        <span class="text-red-500">(✗ N'existe pas)</span>
                    @endif
                </li>
            </ul>
            
            <h3 class="text-md font-semibold mb-2">Variables d'environnement</h3>
            <ul class="list-disc pl-5">
                <li>APP_URL : <code class="bg-gray-100 px-1 py-0.5 rounded">{{ env('APP_URL') }}</code></li>
                <li>FILESYSTEM_DISK : <code class="bg-gray-100 px-1 py-0.5 rounded">{{ env('FILESYSTEM_DISK', 'local') }}</code></li>
                <li>FILESYSTEM_DRIVER : <code class="bg-gray-100 px-1 py-0.5 rounded">{{ env('FILESYSTEM_DRIVER', 'local') }}</code></li>
            </ul>
        </div>
    </div>
</div>
@endsection 