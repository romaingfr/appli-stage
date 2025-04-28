<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* En-tête avec le logo et les infos */
        .header {
            background-color: #0094D9;
            color: white;
            padding: 20px 40px;
            position: relative;
        }

        .header-content {
            margin-top: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: white;
        }

        .document-title {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }

        /* Container principal */
        .container {
            padding: 40px;
        }

        /* Informations client et site */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
        }

        .info-block {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
        }

        .info-block h3 {
            color: #0094D9;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 2px solid #0094D9;
            padding-bottom: 5px;
        }

        /* Sections */
        .section {
            margin-bottom: 30px;
        }

        .section-title {
            background-color: #0094D9;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        /* Tableaux */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }

        th {
            background-color: #f8f9fa;
            color: #0094D9;
            font-weight: bold;
            text-align: left;
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        td {
            padding: 10px;
            border: 1px solid #dee2e6;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Badge statuts */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        /* Pied de page */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 20px 40px;
            background-color: #f8f9fa;
            border-top: 2px solid #0094D9;
            font-size: 10px;
            color: #666;
        }

        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .col {
            flex: 1;
        }

        .label {
            font-weight: bold;
            color: #0094D9;
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="header-content">
        <h1 class="company-name">IOTIZ</h1>
        <div class="document-title">Fiche détaillée du site - {{ date('d/m/Y') }}</div>
    </div>
</div>

<div class="container">
    <div class="info-grid">
        <div class="info-block">
            <h3>Informations Client</h3>
            <div class="row">
                <div class="col">
                    <p><span class="label">Société :</span> {{ $client->name_boite }}</p>
                    <p><span class="label">Contact :</span> {{ $client->prenom_client }} {{ $client->nom_client }}</p>
                    <p><span class="label">Email :</span> {{ $client->email }}</p>
                    <p><span class="label">Téléphone :</span> {{ $client->numero_telephone }}</p>
                    <p><span class="label">Mobile :</span> {{ $client->numero_mobile }}</p>
                </div>
            </div>
        </div>

        <div class="info-block">
            <h3>Informations Site</h3>
            <div class="row">
                <div class="col">
                    <p><span class="label">Nom du site :</span> {{ $site->nom }}</p>
                    <p><span class="label">Adresse :</span> {{ $site->adresse }}</p>
                    <p><span class="label">Code postal :</span> {{ $site->code_postal }}</p>
                    <p><span class="label">Ville :</span> {{ $site->ville }}</p>
                    <p><span class="label">Type :</span> {{ $site->principal ? 'Principal' : 'Secondaire' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if(isset($site->services) && !empty($site->services))
        <div class="section">
            <h2 class="section-title">Configuration des Services</h2>

            @if(isset($site->services['configuration']))
                <table>
                    <tr>
                        <th>SVI</th>
                        <th>Nombre de canaux</th>
                        <th>Cloud</th>
                        <th>Type d'accès</th>
                        <th>Débit</th>
                    </tr>
                    <tr>
                        <td>{{ $site->services['configuration']['svi'] ? 'Oui' : 'Non' }}</td>
                        <td>{{ $site->services['configuration']['channel_count'] ?? '0' }}</td>
                        <td>{{ $site->services['configuration']['cloud'] ? 'Oui' : 'Non' }}</td>
                        <td>{{ $site->services['configuration']['access_type'] ?? '-' }}</td>
                        <td>{{ $site->services['configuration']['debit'] ?? '-' }}</td>
                    </tr>
                </table>
            @endif

            @if(isset($site->services['lignes']) && count($site->services['lignes']) > 0)
                <h3 class="section-title">Lignes téléphoniques</h3>
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Numéro</th>
                        <th>Opérateur</th>
                        <th>Data</th>
                        <th>International</th>
                        <th>N° SIM</th>
                    </tr>
                    @foreach($site->services['lignes'] as $ligne)
                        <tr>
                            <td>{{ $ligne['nom'] ?? '-' }}</td>
                            <td>{{ $ligne['prenom'] ?? '-' }}</td>
                            <td>{{ $ligne['numero'] ?? '-' }}</td>
                            <td>{{ $ligne['operateur'] ?? '-' }}</td>
                            <td>{{ $ligne['data'] ?? '-' }}</td>
                            <td>{{ $ligne['international'] ? 'Oui' : 'Non' }}</td>
                            <td>{{ $ligne['sim'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    @endif
</div>

<div class="footer">
    <p>Document généré automatiquement par IOTIZ - {{ date('d/m/Y H:i') }}</p>
    <p>© {{ date('Y') }} IOTIZ - Tous droits réservés</p>
</div>
</body>
</html>
