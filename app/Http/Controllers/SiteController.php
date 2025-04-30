<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Site::class, 'site');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->client_id) {
            $sites = Site::where('client_id', $user->client_id)
                ->paginate(10);
        } else {
            $sites = Site::with('client')
                ->latest()
                ->paginate(10);
        }

        return view('sites.index', compact('sites'));
    }

    public function create(Client $client)
    {
        $this->authorize('create', [Site::class, $client]);
        return view('sites.create', compact('client'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name_boite' => 'required|string|max:255',
            'siret' => 'nullable|string|size:14|unique:sites',
            'forme_juridique' => 'nullable|string|max:255',
            'code_naf' => 'nullable|string|max:10',
            'adresse_siege' => 'required|string|max:255',
            'code_postal' => 'required|string|max:5',
            'localite' => 'required|string|max:255',
            'code_insee' => 'nullable|string|max:5',
        ]);

        // Vérifie si c'est le premier site pour ce client
        $sitesCount = Site::where('client_id', $validated['client_id'])->count();
        $validated['principal'] = ($sitesCount === 0);

        $site = Site::create($validated);

        return redirect()
            ->route('clients.show', $site->client_id)
            ->with('success', 'Site ajouté avec succès');
    }

    public function show($clientId, $siteId)
    {
        // Récupérer le site avec les informations du client principal
        $site = Site::where('client_id', $clientId)
            ->where('id', $siteId)
            ->firstOrFail();

        // Récupérer le client principal
        $client = Client::findOrFail($clientId);

        // Formater les données avec les informations de contact du client principal
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $site->id,
                'name_boite' => $site->name_boite,
                'siret' => $site->siret,
                'adresse_siege' => $site->adresse_siege,
                'code_postal' => $site->code_postal,
                'localite' => $site->localite,
                // Utiliser les informations de contact du client principal
                'contact_nom' => $client->prenom_client . ' ' . $client->nom_client,
                'telephone' => $client->numero_telephone,
                'mobile' => $client->numero_mobile,
                'email' => $client->email
            ]
        ]);
    }

    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'name_boite' => 'required|string|max:255',
            'siret' => "nullable|string|size:14|unique:sites,siret,{$site->id}",
            'forme_juridique' => 'nullable|string|max:255',
            'code_naf' => 'nullable|string|max:10',
            'adresse_siege' => 'required|string|max:255',
            'code_postal' => 'required|string|max:5',
            'localite' => 'required|string|max:255',
            'code_insee' => 'nullable|string|max:5',
        ]);

        $site->update($validated);

        return redirect()
            ->route('clients.show', $site->client_id)
            ->with('success', 'Site mis à jour avec succès');
    }

    public function destroy(Site $site)
    {
        $client_id = $site->client_id;
        $site->delete();

        return redirect()
            ->route('clients.show', $client_id)
            ->with('success', 'Site supprimé avec succès');
    }

    public function details(Site $site)
    {
        $this->authorize('view', $site);

        // Chargez explicitement tous les attributs dont vous avez besoin
        $site->load('client');

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $site->id,
                'nom' => $site->name_boite,
                'telephone' => $site->telephone,
                'mobile' => $site->mobile,     // Ajout explicite du mobile
                'email' => $site->email,
                'contact_nom' => $site->contact_nom,
                // autres champs si nécessaires...
            ]
        ]);
    }
    public function services(Client $client, $siteId)
    {
        try {
            // Récupération du site (code inchangé)
            if ($siteId === 'principal') {
                $site = $client->sites()->where('principal', true)->first();
                if (!$site) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Site principal non trouvé'
                    ], 404);
                }
            } else {
                $site = $client->sites()->findOrFail($siteId);
            }

            // Récupération du service (correction ici)
            $service = $site->services()->first();
            $serviceData = $service ? [
                'configuration' => $service->configuration,
                'lignes' => $service->lignes
            ] : [
                'configuration' => [
                    'svi' => false,
                    'channel_count' => null,
                    'cloud' => false,
                    'access_type' => '',
                    'debit' => ''
                ],
                'lignes' => []
            ];

            return response()->json([
                'success' => true,
                'data' => $serviceData
            ])->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            // Gestion d'erreur inchangée
        }
    }

    public function updateServices(Request $request, Client $client, $siteId)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'configuration' => 'required|array',
                'configuration.svi' => 'required|boolean',
                'configuration.channel_count' => 'required|integer|min:0',
                'configuration.cloud' => 'required|boolean',
                'configuration.access_type' => 'required|string',
                'configuration.debit' => 'required|string',
                'lignes' => 'present|array',
                'lignes.*.nom' => 'nullable|string',
                'lignes.*.prenom' => 'nullable|string',
                'lignes.*.numero' => 'nullable|string',
                'lignes.*.operateur' => 'nullable|string',
                'lignes.*.data' => 'nullable|string',
                'lignes.*.international' => 'boolean',
                'lignes.*.sim' => 'nullable|string',
                // Règles pour lignes_mobiles
                'lignes_mobiles' => 'present|array',
                'lignes_mobiles.*.numero' => 'nullable|string',
                'lignes_mobiles.*.forfait' => 'nullable|string',
                'lignes_mobiles.*.sim' => 'nullable|string',
                'lignes_mobiles.*.date_activation' => 'nullable|date',
            ]);

            // Récupération du site
            $site = $siteId === 'principal'
                ? $client->sites()->where('principal', true)->first()
                : $client->sites()->findOrFail($siteId);

            if (!$site) {
                return response()->json([
                    'success' => false,
                    'message' => 'Site non trouvé'
                ], 404);
            }

            // Mise à jour des services
            DB::beginTransaction();
            $service = $site->services()->updateOrCreate(
                [], // Conditions (vide pour associer au site)
                [
                    'configuration' => $validatedData['configuration'],
                    'lignes' => $validatedData['lignes'],
                    'lignes_mobiles' => $validatedData['lignes_mobiles'] ?? []
                ]
            );
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Services mis à jour avec succès',
                'service' => $service
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Erreur lors de la mise à jour des services', [
                'error' => $e->getMessage(),
                'client_id' => $client->id,
                'site_id' => $siteId,
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour des services',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPrincipalServices()
    {
        try {
            $site = Site::where('principal', true)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'services' => $site->services
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des services'
            ], 500);
        }
    }

    public function updatePrincipalServices(Request $request)
    {
        $client = Auth::user()->client;

        $validated = $request->validate([
            'services' => 'required|array'
        ]);

        $client->services = $validated['services'];
        $client->save();

        return response()->json([
            'message' => 'Services mis à jour avec succès'
        ]);
    }

    /**
     * Exporter les informations du site en PDF
     */
    public function exportPDF(Client $client, $site)
    {
        try {
            // Logique pour trouver le site (principal ou secondaire)
            if ($site === 'principal') {
                $site = $client->sites()->where('principal', true)->first();
            } else {
                $site = Site::findOrFail($site);
            }

            // Récupérer les services
            $services = $site->services()->first();

            // Préparer les données traitées des services
            $processedServices = [];
            if ($services) {
                // Fonction utilitaire pour évaluer les valeurs booléennes
                $isValueTrue = function($value) {
                    if (is_string($value)) {
                        $value = strtolower(trim($value));
                        return $value === 'true' || $value === 'yes' || $value === 'oui' || $value === '1' || $value === 'on';
                    }
                    return (bool)$value;
                };

                // Fonction pour récupérer la valeur appropriée
                $getValue = function($services, $key) {
                    if (is_array($services)) {
                        if (isset($services['configuration']) && isset($services['configuration'][$key])) {
                            return $services['configuration'][$key];
                        } elseif (isset($services[$key])) {
                            return $services[$key];
                        }
                    } else {
                        if (isset($services->configuration) && isset($services->configuration->$key)) {
                            return $services->configuration->$key;
                        } elseif (isset($services->$key)) {
                            return $services->$key;
                        }
                    }
                    return null;
                };

                // Préparer les données traitées
                $config = $services->configuration ?? [];
                $processedServices['svi'] = $isValueTrue($getValue($services, 'svi'));
                $processedServices['channel_count'] = $getValue($services, 'channel_count') ?? '0';
                $processedServices['cloud'] = $isValueTrue($getValue($services, 'cloud'));
                $processedServices['access_type'] = $getValue($services, 'access_type') ?? 'Non renseigné';
                $processedServices['debit'] = $getValue($services, 'debit') ?? 'Non renseigné';
            }

            // Préparer les données
            $data = [
                'client' => $client,
                'site' => $site,
                'services' => $services,
                'processedServices' => $processedServices
            ];

            // Générer le PDF
            $pdf = PDF::loadView('pdf.site-details', $data);

            // Afficher dans le navigateur
            return $pdf->stream('site-details.pdf');
        } catch (\Exception $e) {
            \Log::error("Erreur PDF: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function updateField(Request $request, Client $client, $site)
    {
        if ($site === 'principal') {
            $siteModel = $client->sites()->where('principal', true)->firstOrFail();
        } else {
            $siteModel = $client->sites()->findOrFail($site);
        }

        $field = $request->field;
        $value = $request->value;

        // Vérifier que le champ existe dans le modèle
        if (!in_array($field, $siteModel->getFillable())) {
            return response()->json(['message' => 'Champ non autorisé'], 422);
        }

        try {
            $siteModel->$field = $value;
            $siteModel->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
