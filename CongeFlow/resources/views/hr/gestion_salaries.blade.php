@extends('layouts.app')

@section('title', 'Gestion des salariés')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des salariés</h1>
        <p class="text-gray-600">Ajoutez, modifiez ou supprimez des salariés</p>
    </div>
    
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    <div class="flex justify-end mb-4">
        <a href="{{ route('hr.salaries.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-plus mr-2"></i> Ajouter un salarié
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Liste des salariés</h2>
            <div class="flex space-x-2">
                <form action="{{ route('hr.salaries.index') }}" method="GET" class="flex space-x-2">
                    <div class="relative">
                        <select name="service" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                            <option value="">Tous les services</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>
                                    {{ $service->nom }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    <div class="relative">
                        <select name="status" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="actif" {{ request('status') == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="en congé" {{ request('status') == 'en congé' ? 'selected' : '' }}>En congé</option>
                            <option value="inactif" {{ request('status') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    <div class="relative">
                        <input type="text" name="search" placeholder="Rechercher un salarié" value="{{ request('search') }}" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-sm">
                    </div>
                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Salarié
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Service
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Poste
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date d'embauche
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($salaries as $salarie)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($salarie->photoProfile)
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $salarie->photoProfile) }}" alt="{{ $salarie->nom }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                                                <span>{{ substr($salarie->prenom, 0, 1) }}{{ substr($salarie->nom, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $salarie->prenom }} {{ $salarie->nom }}</div>
                                        <div class="text-sm text-gray-500">{{ $salarie->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                EMP{{ str_pad($salarie->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $salarie->service ? $salarie->service->nom : 'Non assigné' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $salarie->poste ?? 'Non spécifié' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $salarie->date_embauche ? date('d/m/Y', strtotime($salarie->date_embauche)) : date('d/m/Y', strtotime($salarie->dateInscription)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($salarie->status == 'actif')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Actif
                                    </span>
                                @elseif($salarie->status == 'en congé')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        En congé
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('hr.salaries.edit', $salarie) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('hr.salaries.destroy', $salarie) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce salarié ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Aucun salarié trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Affichage de 
                <span class="font-medium">{{ $salaries->firstItem() ?? 0 }}</span> 
                à 
                <span class="font-medium">{{ $salaries->lastItem() ?? 0 }}</span> 
                sur 
                <span class="font-medium">{{ $salaries->total() }}</span> 
                résultats
            </div>
            <div class="flex space-x-2">
                {{ $salaries->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


