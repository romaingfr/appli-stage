@extends('layouts.app')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Archivo Narrow', sans-serif;
            background-color: #f8f9fa;
        }

        /* En-tête et titres */
        .iotiz-header {
            background-color: #009FE3;
            color: white;
            font-weight: 600;
            padding: 1.25rem;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .iotiz-header::before {
            content: '\f4df';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            margin-right: 10px;
            font-size: 1.25rem;
        }

        /* Boutons */
        .iotiz-btn-primary {
            background-color: #009FE3;
            border-color: #009FE3;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 159, 227, 0.2);
        }

        .iotiz-btn-primary:hover {
            background-color: #0080B3;
            border-color: #0080B3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 159, 227, 0.3);
        }

        .btn-danger {
            background-color: #E8393F;
            border-color: #E8393F;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(232, 57, 63, 0.2);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #d42e34;
            border-color: #d42e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(232, 57, 63, 0.3);
        }

        /* Badges */
        .badge {
            font-family: 'Archivo Narrow', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .iotiz-badge-disponible {
            background-color: #7BC043;
            color: white;
        }

        .iotiz-badge-service {
            background-color: #009FE3;
            color: white;
        }

        .iotiz-badge-maintenance {
            background-color: #F7931E;
            color: white;
        }

        /* Tableau */
        .iotiz-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .iotiz-table th {
            background-color: #E6F4FA;
            color: #1a3b54;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem;
            font-size: 0.9rem;
            border: none;
        }

        .iotiz-table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #f0f0f0;
            font-size: 1rem;
        }

        .iotiz-table tbody tr {
            transition: all 0.3s ease;
        }

        .iotiz-table tbody tr:hover {
            background-color: rgba(0, 159, 227, 0.05);
            transform: translateY(-1px);
        }

        /* Card */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: fadeIn 0.6s ease-in-out;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Actions */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-buttons .btn {
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .iotiz-table {
                display: block;
                overflow-x: auto;
            }
        }

        /* Alert */
        .alert-success {
            background-color: rgba(123, 192, 67, 0.15);
            border-left: 4px solid #7BC043;
            border-radius: 8px;
            padding: 1rem 1.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header iotiz-header">Gestion des terminaux</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-secondary">Liste des terminaux disponibles</h5>
                            <a href="{{ route('terminals.create') }}" class="btn iotiz-btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Ajouter un terminal
                            </a>
                        </div>

                        <table class="table iotiz-table">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="20%">Nom</th>
                                <th width="20%">Modèle</th>
                                <th width="20%">Numéro de série</th>
                                <th width="15%">Statut</th>
                                <th width="20%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($terminals as $terminal)
                                <tr>
                                    <td>{{ $terminal->id }}</td>
                                    <td>{{ $terminal->name }}</td>
                                    <td>{{ $terminal->model }}</td>
                                    <td>{{ $terminal->serial_number ?? 'Non spécifié' }}</td>
                                    <td>
                                        @if($terminal->status == 'disponible')
                                            <span class="badge iotiz-badge-disponible">
                                                <i class="fas fa-check-circle me-1"></i>Disponible
                                            </span>
                                        @elseif($terminal->status == 'en_service')
                                            <span class="badge iotiz-badge-service">
                                                <i class="fas fa-cog me-1"></i>En service
                                            </span>
                                        @elseif($terminal->status == 'maintenance')
                                            <span class="badge iotiz-badge-maintenance">
                                                <i class="fas fa-tools me-1"></i>Maintenance
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('terminals.edit', $terminal) }}" class="btn btn-sm iotiz-btn-primary">
                                                <i class="fas fa-edit me-1"></i>Modifier
                                            </a>
                                            <form action="{{ route('terminals.destroy', $terminal) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce terminal?')">
                                                    <i class="fas fa-trash-alt me-1"></i>Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="py-3">
                                            <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                                            <p class="mb-0 mt-2">Aucun terminal trouvé</p>
                                            <p class="text-muted small">Ajoutez votre premier terminal en cliquant sur le bouton "Ajouter un terminal"</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
