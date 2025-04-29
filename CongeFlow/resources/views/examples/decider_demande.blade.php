@extends('layouts.app')

@section('title', 'Décider sur une demande')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Décision sur une demande de congé</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Cette page démontre l'interface pour prendre une décision sur une demande de congé.
                    </div>
                    
                    <h6 class="mb-3">Détails de la demande</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 150px">Employé</th>
                                        <td>Amadou Diallo</td>
                                    </tr>
                                    <tr>
                                        <th>Type de congé</th>
                                        <td>Congé annuel</td>
                                    </tr>
                                    <tr>
                                        <th>Date de début</th>
                                        <td>15/07/2023</td>
                                    </tr>
                                    <tr>
                                        <th>Date de fin</th>
                                        <td>22/07/2023</td>
                                    </tr>
                                    <tr>
                                        <th>Durée</th>
                                        <td>8 jours</td>
                                    </tr>
                                    <tr>
                                        <th>Motif</th>
                                        <td>Vacances familiales</td>
                                    </tr>
                                    <tr>
                                        <th>Statut actuel</th>
                                        <td><span class="badge bg-warning">En attente</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Solde de congés</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Solde initial:</span>
                                        <span><strong>30 jours</strong></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Congés pris:</span>
                                        <span><strong>12 jours</strong></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Solde disponible:</span>
                                        <span><strong>18 jours</strong></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Cette demande:</span>
                                        <span><strong>8 jours</strong></span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span>Solde après approbation:</span>
                                        <span><strong>10 jours</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3">Actions disponibles</h6>
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('includes.approval_buttons', ['demande' => (object)['id' => 123]])
                        </div>
                    </div>
                    
                    <h6 class="mb-3">Historique des actions</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Action</th>
                                <th>Par</th>
                                <th>Commentaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10/07/2023 09:15</td>
                                <td>Création de la demande</td>
                                <td>Amadou Diallo</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>11/07/2023 10:30</td>
                                <td>Validation par N+1</td>
                                <td>Marie Dubois</td>
                                <td>Pas de commentaire</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 