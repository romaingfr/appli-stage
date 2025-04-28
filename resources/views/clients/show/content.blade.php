@extends('layouts.app')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
    @include('clients.show.style')

    <div class="container-fluid py-4">
        <div class="row g-0">
            <!-- Menu latéral -->
            <div class="col-auto d-none d-lg-block">
                <div class="sidebar bg-light border-end" style="width: 250px; min-height: 100vh;">
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <div class="status-indicator status-active"></div>
                            <h6 class="mb-0">{{ $client->name_boite }}</h6>
                        </div>
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-id-card me-1"></i> ID: {{ $client->id }}
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="nav flex-column nav-pills">
                            <a class="nav-link active" id="tab-overview" href="#overview" onclick="switchTab('overview')"><i class="fas fa-home me-2"></i>Vue d'ensemble</a>
                            <a class="nav-link" id="tab-services" href="#services" onclick="switchTab('services')"><i class="fas fa-cogs me-2"></i>Services</a>
                            <a class="nav-link" id="tab-billing" href="#billing" onclick="switchTab('billing')"><i class="fas fa-file-invoice-dollar me-2"></i>Facturation</a>
                            <a class="nav-link" id="tab-documents" href="#documents" onclick="switchTab('documents')"><i class="fas fa-folder me-2"></i>Documents</a>
                            <a class="nav-link" id="tab-history" href="#history" onclick="switchTab('history')"><i class="fas fa-history me-2"></i>Historique</a>
                        </div>
                    </div>
                    <div class="p-3 border-top mt-auto">
                        <div class="d-grid">
                            <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>Imprimer la fiche
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contenu principal -->
            <div class="col">
                <!-- En-tête -->
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/clients">Clients</a></li>
                            <li class="breadcrumb-item">{{ $client->name_boite }}</li>
                            <li class="breadcrumb-item active" id="currentSection">Vue d'ensemble</li>
                        </ol>
                    </nav>
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0">{{ $client->name_boite }}</h1>
                    </div>
                </div>

                <!-- Navigation des sites -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs">
                            @if($client->sites->count() > 0)
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-site-id="principal" onclick="showSiteDetails('principal')">
                                        <i class="fas fa-building me-2"></i>Site Principal
                                    </button>
                                </li>
                                @foreach($client->sites as $site)
                                    @if(!$site->principal)
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-site-id="{{ $site->id }}" onclick="showSiteDetails({{ $site->id }})">
                                                <i class="fas fa-building me-2"></i>Site {{ $loop->iteration }}
                                            </button>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('clients.sites.create', ['client' => $client->id]) }}" class="nav-link text-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Ajouter un site
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contenu -->
                <div id="contentArea">
                    <!-- Informations client -->
                    <div id="clientInfos">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h3 class="h5 mb-0"><i class="fas fa-building me-2"></i>Entreprise principale</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Nom</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-name_boite">{{ $client->name_boite }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="name_boite" data-original="{{ $client->name_boite }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>SIRET</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-siret">{{ $client->siret }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="siret" data-original="{{ $client->siret }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Forme juridique</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-forme_juridique">{{ $client->forme_juridique }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="forme_juridique" data-original="{{ $client->forme_juridique }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Code NAF</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-code_naf">{{ $client->code_naf }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="code_naf" data-original="{{ $client->code_naf }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h3 class="h5 mb-0"><i class="fas fa-user me-2"></i>Contact principal</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Prénom</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-prenom_client">{{ $client->prenom_client }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="prenom_client" data-original="{{ $client->prenom_client }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Nom</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-nom_client">{{ $client->nom_client }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="nom_client" data-original="{{ $client->nom_client }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Téléphone fixe</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-numero_telephone">{{ $client->numero_telephone ?: 'Non renseigné' }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="numero_telephone" data-original="{{ $client->numero_telephone }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Mobile</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-numero_mobile">{{ $client->numero_mobile ?: 'Non renseigné' }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="numero_mobile" data-original="{{ $client->numero_mobile }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-email">{{ $client->email }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="email" data-original="{{ $client->email }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h3 class="h5 mb-0"><i class="fas fa-map-marker-alt me-2"></i>Adresse du siège</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Adresse</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-adresse_siege">{{ $client->adresse_siege }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="adresse_siege" data-original="{{ $client->adresse_siege }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Code postal</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-code_postal">{{ $client->code_postal }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="code_postal" data-original="{{ $client->code_postal }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Localité</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-localite">{{ $client->localite }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="localite" data-original="{{ $client->localite }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Code INSEE</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-code_insee">{{ $client->code_insee ?: 'Non renseigné' }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="code_insee" data-original="{{ $client->code_insee }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h3 class="h5 mb-0"><i class="fas fa-file-invoice me-2"></i>Adresse de facturation</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Prénom</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-prenom_facturation">{{ $client->prenom_facturation }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="prenom_facturation" data-original="{{ $client->prenom_facturation }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Nom</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-nom_facturation">{{ $client->nom_facturation }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="nom_facturation" data-original="{{ $client->nom_facturation }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Téléphone</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-telephone_facturation">{{ $client->telephone_facturation ?: 'Non renseigné' }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="telephone_facturation" data-original="{{ $client->telephone_facturation }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Adresse</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-adresse_facturation">{{ $client->adresse_facturation }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="adresse_facturation" data-original="{{ $client->adresse_facturation }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Code postal</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-code_postal_facturation">{{ $client->code_postal_facturation }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="code_postal_facturation" data-original="{{ $client->code_postal_facturation }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Ville</th>
                                                <td class="d-flex align-items-center justify-content-between">
                                                    <span id="display-ville_facturation">{{ $client->ville_facturation }}</span>
                                                    <button class="btn btn-xs text-secondary edit-btn" data-field="ville_facturation" data-original="{{ $client->ville_facturation }}">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Détails du site -->
                    <div id="selectedSiteDetails" style="display: none;" class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex align-items-center gap-3">
                                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" onclick="showFullClientInfo()">
                                        <i class="fas fa-arrow-left me-2"></i>Retour
                                    </button>
                                    <h3 class="h5 mb-0" id="selectedSiteTitle"></h3>
                                </div>
                                <div class="card-body">
                                    <div id="siteInfo"></div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light">
                                    <h3 class="h5 mb-0"><i class="fas fa-cogs me-2"></i>Services du site</h3>
                                </div>
                                <div class="card-body">
                                    <div class="accordion" id="mainAccordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#telephonyHostedSection">
                                                    <i class="fas fa-phone me-2"></i>Téléphonie hébergée
                                                </button>
                                            </h2>
                                            <div id="telephonyHostedSection" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                                                <div class="accordion-body">
                                                    <div class="form-check mb-3">
                                                        <input type="checkbox" class="form-check-input" id="svi">
                                                        <label class="form-check-label" for="svi">SVI</label>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="bg-light">
                                                            <tr>
                                                                <th>Nom</th>
                                                                <th>Prénom</th>
                                                                <th>Numéro de ligne</th>
                                                                <th>Opérateur</th>
                                                                <th>Data (Go)</th>
                                                                <th>International</th>
                                                                <th>N° Carte SIM</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="phoneLinesBody">
                                                            <!-- Les lignes seront ajoutées ici dynamiquement -->
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="text-end mt-3">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPhoneLineModal">
                                                            <i class="fas fa-plus me-1"></i> Ajouter une ligne
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal pour ajouter une ligne téléphonique -->
                                            <div class="modal fade" id="addPhoneLineModal" tabindex="-1" aria-labelledby="addPhoneLineModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addPhoneLineModalLabel">Ajouter une ligne</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="phoneLineForm">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="lastName" class="form-label">Nom</label>
                                                                        <input type="text" class="form-control form-control-sm" id="lastName">
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="firstName" class="form-label">Prénom</label>
                                                                        <input type="text" class="form-control form-control-sm" id="firstName">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phoneNumber" class="form-label">Numéro de ligne</label>
                                                                    <input type="text" class="form-control form-control-sm" id="phoneNumber">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="operator" class="form-label">Opérateur</label>
                                                                    <select class="form-select form-select-sm" id="operator">
                                                                        <option value="">Sélectionner</option>
                                                                        <option value="Orange">Orange</option>
                                                                        <option value="SFR">SFR</option>
                                                                        <option value="Bouygues">Bouygues</option>
                                                                        <option value="Free">Free</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="dataAmount" class="form-label">Data (Go)</label>
                                                                    <input type="number" class="form-control form-control-sm" id="dataAmount" min="0">
                                                                </div>
                                                                <div class="mb-3 form-check">
                                                                    <input type="checkbox" class="form-check-input" id="internationalOption">
                                                                    <label class="form-check-label" for="internationalOption">Option internationale</label>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="simCardNumber" class="form-label">N° Carte SIM</label>
                                                                    <input type="text" class="form-control form-control-sm" id="simCardNumber">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="button" class="btn btn-primary btn-sm" id="savePhoneLine">Enregistrer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accessLinkSection">
                                                    <i class="fas fa-network-wired me-2"></i>Lien d'accès
                                                </button>
                                            </h2>
                                            <div id="accessLinkSection" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <select class="form-select" id="accessType">
                                                            <option value="">Type de lien</option>
                                                            <option value="fibre">Fibre</option>
                                                            <option value="adsl">ADSL</option>
                                                            <option value="sdsl">SDSL</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" id="accessDebit" placeholder="Débit (Mb/s)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSection">
                                                    <i class="fas fa-mobile-alt me-2"></i>Mobile
                                                </button>
                                            </h2>
                                            <div id="mobileSection" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                                                <div class="accordion-body">
                                                    <div class="form-check mb-3">
                                                        <input type="checkbox" class="form-check-input" id="mobileService">
                                                        <label class="form-check-label" for="mobileService">Service mobile</label>
                                                    </div>

                                                    <!-- APRÈS -->
                                                    <div class="table-responsive" id="mobileLinesTable">                                                        <table class="table table-bordered table-sm">
                                                            <thead class="bg-light">
                                                            <tr>
                                                                <th>Nom</th>
                                                                <th>Prénom</th>
                                                                <th>Numéro de ligne</th>
                                                                <th>Opérateur</th>
                                                                <th>Data (Go)</th>
                                                                <th>International</th>
                                                                <th>N° Carte SIM</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="mobileLinesBody">
                                                            <!-- Les lignes seront ajoutées ici dynamiquement -->
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="text-end mt-3">
                                                        <button type="button" class="btn btn-primary btn-sm" id="addMobileLineBtn">
                                                            <i class="fas fa-plus me-1"></i> Ajouter une ligne
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal pour ajouter une ligne mobile -->
                                        <div class="modal fade" id="addMobileLineModal" tabindex="-1" aria-labelledby="addMobileLineModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addMobileLineModalLabel">Ajouter une ligne mobile</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="mobileLineForm">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="mobileLastName" class="form-label">Nom</label>
                                                                    <input type="text" class="form-control form-control-sm" id="mobileLastName">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="mobileFirstName" class="form-label">Prénom</label>
                                                                    <input type="text" class="form-control form-control-sm" id="mobileFirstName">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="mobileNumber" class="form-label">Numéro de ligne</label>
                                                                <input type="text" class="form-control form-control-sm" id="mobileNumber">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="mobileOperator" class="form-label">Opérateur</label>
                                                                <select class="form-select form-select-sm" id="mobileOperator">
                                                                    <option value="">Sélectionner</option>
                                                                    <option value="Orange">Orange</option>
                                                                    <option value="SFR">SFR</option>
                                                                    <option value="Bouygues">Bouygues</option>
                                                                    <option value="Free">Free</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="mobileDataAmount" class="form-label">Data (Go)</label>
                                                                <input type="number" class="form-control form-control-sm" id="mobileDataAmount" min="0">
                                                            </div>
                                                            <div class="mb-3 form-check">
                                                                <input type="checkbox" class="form-check-input" id="mobileInternationalOption">
                                                                <label class="form-check-label" for="mobileInternationalOption">Option internationale</label>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="mobileSimCardNumber" class="form-label">N° Carte SIM</label>
                                                                <input type="text" class="form-control form-control-sm" id="mobileSimCardNumber">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="button" class="btn btn-primary btn-sm" id="saveMobileLine">Enregistrer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cloudSection">
                                                    <i class="fas fa-cloud me-2"></i>Cloud
                                                </button>
                                            </h2>
                                            <div id="cloudSection" class="accordion-collapse collapse" data-bs-parent="#mainAccordion">
                                                <div class="accordion-body">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="cloud">
                                                        <label class="form-check-label" for="cloud">Activer le service Cloud</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-3">
                                        <button id="saveButton" type="button" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Enregistrer les services
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton Supprimer -->
                <div class="text-end mt-4">
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Supprimer le client
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('clients.show.script')
@endsection
