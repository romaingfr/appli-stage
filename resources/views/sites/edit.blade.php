@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <h2 class="mb-0">Modifier le site</h2>
                <a href="{{ route('clients.show', $site->client_id) }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('sites.update', $site->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h3 class="h5 mb-0"><i class="fas fa-building me-2"></i>Informations du site</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name_boite" class="form-label">Nom du site</label>
                                        <input type="text" class="form-control @error('name_boite') is-invalid @enderror"
                                               id="name_boite" name="name_boite" value="{{ old('name_boite', $site->name_boite) }}" required>
                                        @error('name_boite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="siret" class="form-label">SIRET</label>
                                        <input type="text" class="form-control @error('siret') is-invalid @enderror"
                                               id="siret" name="siret" value="{{ old('siret', $site->siret) }}">
                                        @error('siret')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="forme_juridique" class="form-label">Forme juridique</label>
                                        <select class="form-select @error('forme_juridique') is-invalid @enderror" id="forme_juridique" name="forme_juridique" required>
                                            <option value="">Sélectionner une forme juridique</option>
                                            <option value="SARL" {{ old('forme_juridique', $site->forme_juridique) == 'SARL' ? 'selected' : '' }}>SARL</option>
                                            <option value="EURL" {{ old('forme_juridique', $site->forme_juridique) == 'EURL' ? 'selected' : '' }}>EURL</option>
                                            <option value="SAS" {{ old('forme_juridique', $site->forme_juridique) == 'SAS' ? 'selected' : '' }}>SAS</option>
                                            <option value="SASU" {{ old('forme_juridique', $site->forme_juridique) == 'SASU' ? 'selected' : '' }}>SASU</option>
                                            <option value="SA" {{ old('forme_juridique', $site->forme_juridique) == 'SA' ? 'selected' : '' }}>SA</option>
                                            <option value="SNC" {{ old('forme_juridique', $site->forme_juridique) == 'SNC' ? 'selected' : '' }}>SNC</option>
                                            <option value="SELARL" {{ old('forme_juridique', $site->forme_juridique) == 'SELARL' ? 'selected' : '' }}>SELARL</option>
                                            <option value="SCI" {{ old('forme_juridique', $site->forme_juridique) == 'SCI' ? 'selected' : '' }}>SCI</option>
                                            <option value="Auto-entrepreneur" {{ old('forme_juridique', $site->forme_juridique) == 'Auto-entrepreneur' ? 'selected' : '' }}>Auto-entrepreneur</option>
                                            <option value="Entreprise individuelle" {{ old('forme_juridique', $site->forme_juridique) == 'Entreprise individuelle' ? 'selected' : '' }}>Entreprise individuelle</option>
                                        </select>
                                        @error('forme_juridique')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="code_naf" class="form-label">Code NAF</label>
                                        <input type="text" class="form-control @error('code_naf') is-invalid @enderror"
                                               id="code_naf" name="code_naf" value="{{ old('code_naf', $site->code_naf) }}">
                                        @error('code_naf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h3 class="h5 mb-0"><i class="fas fa-map-marker-alt me-2"></i>Adresse</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="adresse_siege" class="form-label">Adresse</label>
                                        <input type="text" class="form-control @error('adresse_siege') is-invalid @enderror"
                                               id="adresse_siege" name="adresse_siege" value="{{ old('adresse_siege', $site->adresse_siege) }}" required>
                                        @error('adresse_siege')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="code_postal" class="form-label">Code postal</label>
                                        <input type="text" class="form-control @error('code_postal') is-invalid @enderror"
                                               id="code_postal" name="code_postal" value="{{ old('code_postal', $site->code_postal) }}" required>
                                        @error('code_postal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="localite" class="form-label">Localité</label>
                                        <input type="text" class="form-control @error('localite') is-invalid @enderror"
                                               id="localite" name="localite" value="{{ old('localite', $site->localite) }}" required>
                                        @error('localite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="code_insee" class="form-label">Code INSEE</label>
                                        <input type="text" class="form-control @error('code_insee') is-invalid @enderror"
                                               id="code_insee" name="code_insee" value="{{ old('code_insee', $site->code_insee) }}">
                                        @error('code_insee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
        }
        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
@endsection
