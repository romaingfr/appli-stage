<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @font-face {
            font-family: 'Archivo Narrow';
            src: url('{{ storage_path('fonts/ArchivoNarrow-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Archivo Narrow';
            src: url('{{ storage_path('fonts/ArchivoNarrow-Bold.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            font-family: 'Archivo Narrow', Arial, sans-serif;
            color: #333;
            margin: 0;
            line-height: 1.25;
            font-size: 11px;
        }

        .wrapper {
            padding: 20px;
        }

        .header-bar {
            background-color: #004672;
            height: 8px;
            width: 100%;
            margin-bottom: 15px;
        }

        /* En-tête avec logo et titre */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 70px; /* Augmenté de 25px à 40px pour créer plus d'espace */
            padding: 0 5px;
            position: relative;
        }

        .logo-container {
            width: 20%;
        }

        .logo {
            max-width: 110px;
            height: auto;
            margin-top: 4px;
        }

        .title-container {
            width: 60%;
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .title {
            font-family: 'Archivo Narrow', Arial, sans-serif;
            font-weight: bold;
            font-size: 24px; /* Augmenté de 18px à 24px pour un titre plus grand */
            color: #004672;
            margin: 0 0 5px 0; /* Légère augmentation de la marge inférieure */
        }

        .subtitle {
            font-size: 14px;
            color: #555;
            margin: 0;
            font-weight: normal;
        }

        /* Sections d'information */
        .info-section {
            margin-bottom: 18px;
        }

        .section-title {
            background-color: #004672;
            color: white;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-card {
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 3px;
            background-color: #f9f9f9;
            font-size: 11px;
            line-height: 1.4;
        }

        .info-card strong {
            color: #004672;
            font-weight: bold;
        }

        /* Tableaux */
        .site-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 1px solid #e0e0e0;
        }

        th, td {
            padding: 6px 8px;
            border: 1px solid #e0e0e0;
            text-align: left;
            font-size: 11px;
        }

        th {
            background-color: #e6f0f7;
            color: #004672;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .services-section table th,
        .services-section table td {
            text-align: center;
        }

        /* Table compacte pour les lignes téléphoniques */
        .compact-table {
            font-size: 10px;
        }

        .compact-table th,
        .compact-table td {
            padding: 5px 6px;
        }

        /* Pied de page */
        .footer {
            background-color: #f9f9f9;
            padding: 8px;
            margin-top: 25px;
            border-top: 1px solid #004672;
            font-size: 9px;
            color: #666;
            text-align: center;
        }

        .footer p {
            margin: 2px 0;
            font-weight: normal;
        }
    </style>
</head>
<body>
<div class="header-bar"></div>
<div class="wrapper">
    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo IOTIZ">
        </div>
        <div class="title-container">
            <h1 class="title">{{ $site->name_boite }}</h1>
            <p class="subtitle">{{ $site->principal ? 'Site Principal' : 'Site Secondaire' }}</p>
        </div>
    </div>

    <div class="info-section">
        <h2 class="section-title">Informations du client</h2>
        <div class="info-card">
            <strong>Société :</strong> {{ $client->name_boite }} &nbsp;|&nbsp;
            <strong>Contact :</strong> {{ $client->prenom_client }} {{ $client->nom_client }} &nbsp;|&nbsp;
            <strong>Tél :</strong> {{ $client->numero_telephone ?? 'Non renseigné' }} &nbsp;|&nbsp;
            <strong>Mobile :</strong> {{ $client->numero_mobile ?? 'Non renseigné' }} &nbsp;|&nbsp;
            <strong>Email :</strong> {{ $client->email ?? 'Non renseigné' }}
        </div>
    </div>

    <div class="info-section">
        <h2 class="section-title">Détails du site</h2>
        <div class="site-info-grid">
            <table>
                <tr>
                    <th>SIRET</th>
                    <td>{{ $site->siret ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <th>Code NAF</th>
                    <td>{{ $site->code_naf ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <th>Forme juridique</th>
                    <td>{{ $site->forme_juridique ?? 'Non renseigné' }}</td>
                </tr>
            </table>
            <table>
                <tr>
                    <th>Adresse</th>
                    <td>{{ $site->adresse_siege ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <th>Code postal</th>
                    <td>{{ $site->code_postal ?? 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <th>Localité</th>
                    <td>{{ $site->localite ?? 'Non renseigné' }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if(isset($services))
        <div class="info-section services-section">
            <h2 class="section-title">Services du site</h2>

            @php
                // Extraction manuelle des valeurs pour éviter les problèmes de structure
                $svi = false;
                $channelCount = '0';
                $cloud = false;
                $accessType = 'Non renseigné';
                $debit = 'Non renseigné';

                // Initialisation du tableau des lignes
                $phoneLines = [];

                if ($services) {
                    // Extraction des données du service
                    if (is_object($services)) {
                        // Si c'est un objet, on vérifie les propriétés
                        if (isset($services->configuration)) {
                            $config = $services->configuration;
                            if (is_string($config)) {
                                $config = json_decode($config, true);
                            }
                            if (is_object($config)) {
                                $svi = isset($config->svi) && ($config->svi === true || $config->svi === 1 || $config->svi === '1' || strtolower((string)$config->svi) === 'true');
                                $channelCount = $config->channel_count ?? '0';
                                $cloud = isset($config->cloud) && ($config->cloud === true || $config->cloud === 1 || $config->cloud === '1' || strtolower((string)$config->cloud) === 'true');
                                $accessType = $config->access_type ?? 'Non renseigné';
                                $debit = $config->debit ?? 'Non renseigné';
                            } elseif (is_array($config)) {
                                $svi = isset($config['svi']) && ($config['svi'] === true || $config['svi'] === 1 || $config['svi'] === '1' || strtolower((string)$config['svi']) === 'true');
                                $channelCount = $config['channel_count'] ?? '0';
                                $cloud = isset($config['cloud']) && ($config['cloud'] === true || $config['cloud'] === 1 || $config['cloud'] === '1' || strtolower((string)$config['cloud']) === 'true');
                                $accessType = $config['access_type'] ?? 'Non renseigné';
                                $debit = $config['debit'] ?? 'Non renseigné';
                            }
                        }

                        // Extraction et traitement des lignes téléphoniques
                        if (isset($services->lignes)) {
                            $rawLines = $services->lignes;

                            if (is_string($rawLines)) {
                                // Si c'est une chaîne JSON, essayer de la décoder
                                $decoded = json_decode($rawLines);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    $phoneLines = $decoded;
                                } elseif (json_last_error() === JSON_ERROR_NONE && is_object($decoded)) {
                                    $phoneLines = array_values((array)$decoded);
                                }
                            } elseif (is_array($rawLines)) {
                                $phoneLines = $rawLines;
                            } elseif (is_object($rawLines)) {
                                $phoneLines = array_values((array)$rawLines);
                            }
                        }
                    } elseif (is_array($services)) {
                        // Si c'est un tableau associatif
                        if (isset($services['configuration'])) {
                            $config = $services['configuration'];
                            if (is_string($config)) {
                                $config = json_decode($config, true);
                            }
                            if (is_array($config)) {
                                $svi = isset($config['svi']) && ($config['svi'] === true || $config['svi'] === 1 || $config['svi'] === '1' || strtolower((string)$config['svi']) === 'true');
                                $channelCount = $config['channel_count'] ?? '0';
                                $cloud = isset($config['cloud']) && ($config['cloud'] === true || $config['cloud'] === 1 || $config['cloud'] === '1' || strtolower((string)$config['cloud']) === 'true');
                                $accessType = $config['access_type'] ?? 'Non renseigné';
                                $debit = $config['debit'] ?? 'Non renseigné';
                            }
                        }

                        // Extraction et traitement des lignes téléphoniques
                        if (isset($services['lignes'])) {
                            $rawLines = $services['lignes'];

                            if (is_string($rawLines)) {
                                // Si c'est une chaîne JSON, essayer de la décoder
                                $decoded = json_decode($rawLines);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    $phoneLines = $decoded;
                                } elseif (json_last_error() === JSON_ERROR_NONE && is_object($decoded)) {
                                    $phoneLines = array_values((array)$decoded);
                                }
                            } elseif (is_array($rawLines)) {
                                $phoneLines = $rawLines;
                            } elseif (is_object($rawLines)) {
                                $phoneLines = array_values((array)$rawLines);
                            }
                        }
                    }
                }

                // Vérifier si nous avons des lignes à afficher
                $hasPhoneLines = !empty($phoneLines);
            @endphp

            <div class="site-info-grid">
                <table>
                    <tr>
                        <th>SVI</th>
                        <td>{{ $svi ? 'Activé' : 'Non activé' }}</td>
                    </tr>
                    <tr>
                        <th>Nombre de lignes</th>
                        <td>{{ $channelCount }}</td>
                    </tr>
                    <tr>
                        <th>Cloud</th>
                        <td>{{ $cloud ? 'Activé' : 'Non activé' }}</td>
                    </tr>
                    <tr>
                        <th>Type d'accès</th>
                        <td>{{ $accessType }}</td>
                    </tr>
                    <tr>
                        <th>Débit</th>
                        <td>{{ $debit }}</td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>&nbsp;</th>--}}
{{--                        <td>&nbsp;</td>--}}
{{--                    </tr>--}}
                </table>
            </div>

            @if($hasPhoneLines)
                <h3 class="section-title">Lignes téléphoniques</h3>

                <table class="compact-table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Numéro</th>
                        <th>Opérateur</th>
                        <th>Data</th>
                        <th>Int.</th>
                        <th>SIM</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($phoneLines as $index => $line)
                        @php
                            // Conversion en objet pour un accès uniforme
                            if (is_array($line)) {
                                $line = (object)$line;
                            }
                        @endphp
                        <tr>
                            <td>{{ $line->nom ?? '-' }}</td>
                            <td>{{ $line->prenom ?? '-' }}</td>
                            <td>{{ $line->numero ?? '-' }}</td>
                            <td>{{ $line->operateur ?? '-' }}</td>
                            <td>{{ $line->data ?? '-' }}</td>
                            <td>{{ isset($line->international) && $line->international ? 'Oui' : 'Non' }}</td>
                            <td>{{ $line->sim ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif

    <div class="footer">
        <p><strong>Document généré par IOTIZ</strong> - {{ date('d/m/Y à H:i') }} - © {{ date('Y') }} IOTIZ - Tous droits réservés</p>
    </div>
</div>
</body>
</html>
