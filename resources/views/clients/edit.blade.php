@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <h2 class="mb-0">Modifier le client</h2>
                <a href="{{ route('clients.show', $client->id) }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Entreprise principale -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h3 class="h5 mb-0"><i class="fas fa-building me-2"></i>Entreprise principale</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name_boite" class="form-label">Nom de l'entreprise</label>
                                        <input type="text" class="form-control @error('name_boite') is-invalid @enderror" id="name_boite" name="name_boite" value="{{ old('name_boite', $client->name_boite) }}" required>
                                        @error('name_boite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="siret" class="form-label">SIRET</label>
                                        <input type="text" class="form-control @error('siret') is-invalid @enderror" id="siret" name="siret" value="{{ old('siret', $client->siret) }}" required>
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
                                        <input type="text" class="form-control @error('code_naf') is-invalid @enderror" id="code_naf" name="code_naf" value="{{ old('code_naf', $client->code_naf) }}" required>
                                        @error('code_naf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact principal -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h3 class="h5 mb-0"><i class="fas fa-user me-2"></i>Contact principal</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="prenom_client" class="form-label">Prénom</label>
                                        <input type="text" class="form-control @error('prenom_client') is-invalid @enderror" id="prenom_client" name="prenom_client" value="{{ old('prenom_client', $client->prenom_client) }}" required>
                                        @error('prenom_client')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nom_client" class="form-label">Nom</label>
                                        <input type="text" class="form-control @error('nom_client') is-invalid @enderror" id="nom_client" name="nom_client" value="{{ old('nom_client', $client->nom_client) }}" required>
                                        @error('nom_client')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="numero_telephone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control @error('numero_telephone') is-invalid @enderror" id="numero_telephone" name="numero_telephone" value="{{ old('numero_telephone', $client->numero_telephone) }}">
                                        @error('numero_telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="numero_mobile" class="form-label">Mobile</label>
                                        <input type="tel" class="form-control @error('numero_mobile') is-invalid @enderror" id="numero_mobile" name="numero_mobile" value="{{ old('numero_mobile', $client->numero_mobile) }}">
                                        @error('numero_mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $client->email) }}" required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Adresse du siège -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h3 class="h5 mb-0"><i class="fas fa-map-marker-alt me-2"></i>Adresse du siège</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="adresse_siege" class="form-label">Adresse</label>
                                        <input type="text" class="form-control @error('adresse_siege') is-invalid @enderror" id="adresse_siege" name="adresse_siege" value="{{ old('adresse_siege', $client->adresse_siege) }}" required>
                                        @error('adresse_siege')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="code_postal" class="form-label">Code postal</label>
                                        <input type="text" class="form-control @error('code_postal') is-invalid @enderror" id="code_postal" name="code_postal" value="{{ old('code_postal', $client->code_postal) }}" required>
                                        @error('code_postal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="localite" class="form-label">Localité</label>
                                        <input type="text" class="form-control @error('localite') is-invalid @enderror" id="localite" name="localite" value="{{ old('localite', $client->localite) }}" required>
                                        @error('localite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="code_insee" class="form-label">Code INSEE</label>
                                        <input type="text" class="form-control @error('code_insee') is-invalid @enderror" id="code_insee" name="code_insee" value="{{ old('code_insee', $client->code_insee) }}" required>
                                        @error('code_insee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Facturation -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h3 class="h5 mb-0"><i class="fas fa-file-invoice me-2"></i>Adresse de facturation</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="prenom_facturation" class="form-label">Prénom</label>
                                        <input type="text" class="form-control @error('prenom_facturation') is-invalid @enderror" id="prenom_facturation" name="prenom_facturation" value="{{ old('prenom_facturation', $client->prenom_facturation) }}" required>
                                        @error('prenom_facturation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nom_facturation" class="form-label">Nom</label>
                                        <input type="text" class="form-control @error('nom_facturation') is-invalid @enderror" id="nom_facturation" name="nom_facturation" value="{{ old('nom_facturation', $client->nom_facturation) }}" required>
                                        @error('nom_facturation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="telephone_facturation" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control @error('telephone_facturation') is-invalid @enderror" id="telephone_facturation" name="telephone_facturation" value="{{ old('telephone_facturation', $client->telephone_facturation) }}">
                                        @error('telephone_facturation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="adresse_facturation" class="form-label">Adresse</label>
                                        <input type="text" class="form-control @error('adresse_facturation') is-invalid @enderror" id="adresse_facturation" name="adresse_facturation" value="{{ old('adresse_facturation', $client->adresse_facturation) }}" required>
                                        @error('adresse_facturation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="code_postal_facturation" class="form-label">Code postal</label>
                                        <input type="text" class="form-control @error('code_postal_facturation') is-invalid @enderror" id="code_postal_facturation" name="code_postal_facturation" value="{{ old('code_postal_facturation', $client->code_postal_facturation) }}" required>
                                        @error('code_postal_facturation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="ville_facturation" class="form-label">Ville</label>
                                        <input type="text" class="form-control @error('ville_facturation') is-invalid @enderror" id="ville_facturation" name="ville_facturation" value="{{ old('ville_facturation', $client->ville_facturation) }}" required>
                                        @error('ville_facturation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
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
