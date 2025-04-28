@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Nouveau site</h2>
                <a href="{{ route('clients.show', $client->id) }}" class="btn btn-export">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.sites.store', ['client' => $client->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="h5 mb-0"><i class="fas fa-building me-2"></i>Informations du site</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name_boite" class="form-label">Nom du site</label>
                                        <input type="text" class="form-control @error('name_boite') is-invalid @enderror"
                                               id="name_boite" name="name_boite" value="{{ old('name_boite') }}" required>
                                        @error('name_boite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="siret" class="form-label">SIRET</label>
                                        <input type="text" class="form-control @error('siret') is-invalid @enderror"
                                               id="siret" name="siret" value="{{ old('siret') }}">
                                        @error('siret')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="forme_juridique" class="form-label">Forme juridique</label>
                                        <select class="form-select @error('forme_juridique') is-invalid @enderror" id="forme_juridique" name="forme_juridique" required>
                                            <option value="">Sélectionner une forme juridique</option>
                                            <option value="SARL" {{ old('forme_juridique', $client->forme_juridique) == 'SARL' ? 'selected' : '' }}>SARL</option>
                                            <option value="EURL" {{ old('forme_juridique', $client->forme_juridique) == 'EURL' ? 'selected' : '' }}>EURL</option>
                                            <option value="SAS" {{ old('forme_juridique', $client->forme_juridique) == 'SAS' ? 'selected' : '' }}>SAS</option>
                                            <option value="SASU" {{ old('forme_juridique', $client->forme_juridique) == 'SASU' ? 'selected' : '' }}>SASU</option>
                                            <option value="SA" {{ old('forme_juridique', $client->forme_juridique) == 'SA' ? 'selected' : '' }}>SA</option>
                                            <option value="SNC" {{ old('forme_juridique', $client->forme_juridique) == 'SNC' ? 'selected' : '' }}>SNC</option>
                                            <option value="SELARL" {{ old('forme_juridique', $client->forme_juridique) == 'SELARL' ? 'selected' : '' }}>SELARL</option>
                                            <option value="SCI" {{ old('forme_juridique', $client->forme_juridique) == 'SCI' ? 'selected' : '' }}>SCI</option>
                                            <option value="Auto-entrepreneur" {{ old('forme_juridique', $client->forme_juridique) == 'Auto-entrepreneur' ? 'selected' : '' }}>Auto-entrepreneur</option>
                                            <option value="Entreprise individuelle" {{ old('forme_juridique', $client->forme_juridique) == 'Entreprise individuelle' ? 'selected' : '' }}>Entreprise individuelle</option>
                                        </select>
                                        @error('forme_juridique')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="code_naf" class="form-label">Code NAF</label>
                                        <input type="text" class="form-control @error('code_naf') is-invalid @enderror"
                                               id="code_naf" name="code_naf" value="{{ old('code_naf') }}">
                                        @error('code_naf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="h5 mb-0"><i class="fas fa-map-marker-alt me-2"></i>Adresse</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="adresse_siege" class="form-label">Adresse</label>
                                        <input type="text" class="form-control @error('adresse_siege') is-invalid @enderror"
                                               id="adresse_siege" name="adresse_siege" value="{{ old('adresse_siege') }}" required>
                                        @error('adresse_siege')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="code_postal" class="form-label">Code postal</label>
                                        <input type="text" class="form-control @error('code_postal') is-invalid @enderror"
                                               id="code_postal" name="code_postal" value="{{ old('code_postal') }}" required>
                                        @error('code_postal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="localite" class="form-label">Localité</label>
                                        <input type="text" class="form-control @error('localite') is-invalid @enderror"
                                               id="localite" name="localite" value="{{ old('localite') }}" required>
                                        @error('localite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="code_insee" class="form-label">Code INSEE</label>
                                        <input type="text" class="form-control @error('code_insee') is-invalid @enderror"
                                               id="code_insee" name="code_insee" value="{{ old('code_insee') }}">
                                        @error('code_insee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer le site
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Variables de la charte graphique IoTIZ */
        :root {
            --primary: #0066B3;
            --primary-rgb: 0, 102, 179;
            --danger: #dc3545;
            --text-color: #2C3E50;
            --border-color: #E9ECEF;
            --shadow: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        /* Style global */
        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Style des cartes */
        .card {
            box-shadow: var(--shadow) !important;
            border: none !important;
            border-radius: 8px !important;
            background: white !important;
        }

        .card-header {
            background: white !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 1.25rem !important;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        /* Style des boutons */
        .btn-export {
            background-color: white !important;
            border: 2px solid var(--primary) !important;
            color: var(--primary) !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            padding: 0.625rem 1.25rem !important;
            border-radius: 6px !important;
            box-shadow: var(--shadow-sm) !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .btn-export:hover {
            background-color: var(--primary) !important;
            color: white !important;
            box-shadow: var(--shadow) !important;
            transform: translateY(-1px) !important;
        }

        .btn-primary {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            padding: 0.625rem 1.25rem !important;
            border-radius: 6px !important;
            box-shadow: var(--shadow-sm) !important;
            transition: all 0.2s ease !important;
        }

        .btn-primary:hover {
            transform: translateY(-1px) !important;
            box-shadow: var(--shadow) !important;
        }

        /* Style des formulaires */
        .form-label {
            font-weight: 500 !important;
            color: var(--text-color) !important;
            margin-bottom: 0.5rem !important;
        }

        .form-control, .form-select {
            border: 1px solid var(--border-color) !important;
            border-radius: 6px !important;
            padding: 0.625rem !important;
            font-size: 0.875rem !important;
            transition: all 0.2s ease !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25) !important;
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--danger) !important;
        }

        .invalid-feedback {
            font-size: 0.75rem !important;
            margin-top: 0.25rem !important;
        }

        /* Espacement */
        .mb-3 {
            margin-bottom: 1.5rem !important;
        }
    </style>
@endsection
