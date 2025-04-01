@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Statistiques en haut -->
    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm">
                <h6>Total Salariés</h6>
                <h3>156</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm">
                <h6>Actifs</h6>
                <h3>142</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm">
                <h6>Départements</h6>
                <h3>8</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center shadow-sm">
                <h6>En Congé</h6>
                <h3>14</h3>
            </div>
        </div>
    </div>

    <!-- Liste des salariés -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Liste des Salariés</h5>
            <a href="#" class="btn btn-primary">+ Ajouter Salarié</a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Salarié</th>
                        <th>Département</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ asset('images/user1.jpg') }}" class="rounded-circle" width="40">
                            Ahmed Benali
                        </td>
                        <td>IT</td>
                        <td>ahmed.benali@company.com</td>
                        <td><span class="badge bg-success">Actif</span></td>
                        <td>
                            <a href="#" class="text-primary">✏️</a>
                            <a href="#" class="text-danger">🗑️</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('images/user2.jpg') }}" class="rounded-circle" width="40">
                            Sara Alami
                        </td>
                        <td>Marketing</td>
                        <td>sara.alami@company.com</td>
                        <td><span class="badge bg-warning text-dark">En congé</span></td>
                        <td>
                            <a href="#" class="text-primary">✏️</a>
                            <a href="#" class="text-danger">🗑️</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
