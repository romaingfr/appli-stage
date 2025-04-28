@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-dark">
                        <i class="fas fa-search me-2 text-primary"></i>Rechercher un client
                    </h4>
                    <a href="{{ route('clients.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Nouveau client
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('clients.search') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label text-muted small">Nom de l'entreprise</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-building"></i></span>
                                    <input type="text" name="name_boite" class="form-control" value="{{ request('name_boite') }}" placeholder="Nom entreprise...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label text-muted small">SIRET</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="siret" class="form-control" value="{{ request('siret') }}" placeholder="Numéro SIRET...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label text-muted small">Nom du contact</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nom_client" class="form-control" value="{{ request('nom_client') }}" placeholder="Nom du contact...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label text-muted small">Téléphone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="telephone" class="form-control" value="{{ request('telephone') }}" placeholder="Numéro...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </button>
                        </div>
                    </div>
                </form>

                @if(isset($clients))
                    @if($clients->count() > 0)
                        <div class="table-responsive border rounded">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Entreprise</th>
                                    <th class="border-0">Contact</th>
                                    <th class="border-0">SIRET</th>
                                    <th class="border-0">Téléphone</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Localité</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr class="cursor-pointer" onclick="window.location='{{ route('clients.show', $client->id) }}'">
                                        <td class="align-middle">{{ $client->name_boite }}</td>
                                        <td class="align-middle">{{ $client->prenom_client }} {{ $client->nom_client }}</td>
                                        <td class="align-middle"><span class="text-muted">{{ $client->siret }}</span></td>
                                        <td class="align-middle">{{ $client->numero_telephone ?: $client->numero_mobile ?: '—' }}</td>
                                        <td class="align-middle">{{ $client->email }}</td>
                                        <td class="align-middle">{{ $client->localite }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $clients->links() }}
                        </div>
                    @else
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-info-circle me-3 fs-4"></i>
                            <div>Aucun client ne correspond à votre recherche</div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary: #008caa;
            --secondary: #00aead;
        }

        .cursor-pointer { cursor: pointer; }
        .cursor-pointer:hover { background-color: rgba(0,0,0,.03); }

        .table th {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .input-group-text {
            border: 1px solid #ced4da;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 2px 4px rgba(0,140,170,.15);
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
    </style>
@endsection
