<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Client;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPrincipal(Client $client)
    {
        try {
            $service = Service::where('client_id', $client->id)
                ->whereNull('site_id')
                ->first();

            return response()->json($service ?? null, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    public function get(Site $site)
    {
        try {
            $service = Service::where('site_id', $site->id)->first();
            return response()->json($service ?? null, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    public function storePrincipal(Request $request, Client $client)
    {
        Log::info('Début updateServices', [
            'client_id' => $client->id,
            'site' => 'principal',
            'request_data' => $request->all()
        ]);

        try {
            $validatedData = $request->validate([
                'configuration' => 'required|array',
                'configuration.svi' => 'required|boolean',
                'configuration.channel_count' => 'required|integer',
                'configuration.cloud' => 'required|boolean',
                'configuration.access_type' => 'required|string',
                'configuration.debit' => 'required|string',
                'lignes' => 'array'
            ]);

            DB::beginTransaction();

            // Modifier les méthodes storePrincipal et update :
            $service = Service::updateOrCreate(
                ['client_id' => $client->id, 'site_id' => null], // ou site_id => $siteId dans update()
                [
                    'configuration' => $validatedData['configuration'],
                    'lignes' => $validatedData['lignes'] ?? [],
                    'lignes_mobiles' => $validatedData['lignes_mobiles'] ?? []
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'service' => $service
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur mise à jour services', [
                'error' => $e->getMessage(),
                'client_id' => $client->id
            ]);

            return response()->json([
                'message' => 'Erreur lors de la mise à jour des services'
            ], 500);
        }
    }

    public function update(Request $request, Client $client, $siteId)
    {
        try {
            // Utiliser validateServiceData au lieu de la validation personnalisée incomplète
            $validatedData = $this->validateServiceData($request);

            DB::beginTransaction();

            $service = Service::updateOrCreate(
                [
                    'site_id' => $siteId,
                    'client_id' => $client->id
                ],
                [
                    'configuration' => $validatedData['configuration'],
                    'lignes' => $validatedData['lignes'] ?? [],
                    'lignes_mobiles' => $validatedData['lignes_mobiles'] ?? []
                ]
            );

            DB::commit();

            // Ajout de logging pour débogage
            Log::info('Service mis à jour avec succès', [
                'service_id' => $service->id,
                'lignes_mobiles_count' => count($validatedData['lignes_mobiles'] ?? [])
            ]);

            return response()->json([
                'success' => true,
                'service' => $service
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur mise à jour services', [
                'error' => $e->getMessage(),
                'client_id' => $client->id,
                'site_id' => $siteId
            ]);

            return response()->json([
                'message' => 'Erreur lors de la mise à jour des services'
            ], 500);
        }
    }

    private function validateServiceData(Request $request)
    {
        return $request->validate([
            'configuration' => 'required|array',
            'configuration.svi' => 'required|boolean',
            'configuration.channel_count' => 'required|integer|min:0',
            'configuration.cloud' => 'required|boolean',
            'configuration.access_type' => 'required|string',
            'configuration.debit' => 'required|string',
            'lignes' => 'required_if:configuration.channel_count,>,0|array',
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
    }

    private function getSite(Client $client, $siteId)
    {
        $site = $siteId === 'principal'
            ? $client->sites()->whereNull('parent_id')->first()
            : $client->sites()->findOrFail($siteId);

        if (!$site) {
            throw new \Exception('Site non trouvé');
        }

        return $site;
    }
}
