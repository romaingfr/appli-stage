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
            // Assouplir la validation pour permettre l'envoi de lignes avec structure JavaScript
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'site_id' => 'required',
                'configuration' => 'required|array',
                'configuration.svi' => 'required|integer',
                'configuration.channel_count' => 'required|integer|min:0',
                'configuration.cloud' => 'required|integer',
                'configuration.access_type' => 'required|string',
                'configuration.debit' => 'required|string',
                'lignes' => 'present|array',
                'lignes_mobiles' => 'present|array',
                'services' => 'present|array',
            ]);

            DB::beginTransaction();

            // Loguer les données reçues pour débogage
            Log::info('Données reçues pour mise à jour service', [
                'lignes_count' => count($validatedData['lignes'] ?? []),
                'lignes' => $validatedData['lignes']
            ]);

            $service = Service::updateOrCreate(
                [
                    'site_id' => $siteId,
                    'client_id' => $client->id
                ],
                [
                    'nom' => $request->input('nom', 'Service '.$siteId),
                    'type' => $request->input('type', 'standard'),
                    'status' => $request->input('status', 1),
                    'configuration' => $validatedData['configuration'],
                    'lignes' => $validatedData['lignes'] ?? [],
                    'lignes_mobiles' => $validatedData['lignes_mobiles'] ?? [],
                    'services' => $validatedData['services'] ?? []
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Services mis à jour avec succès',
                'service' => $service
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur mise à jour services', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'client_id' => $client->id,
                'site_id' => $siteId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour des services',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    private function validateServiceData(Request $request)
    {
        return $request->validate([
            'client_id' => 'required|exists:clients,id',
            'site_id' => 'required|exists:sites,id',
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
            'lignes.*.mobile' => 'nullable|string',
            'lignes.*.marque' => 'nullable|string',
            'lignes.*.type_terminal' => 'nullable|string',
            'lignes.*.numero_serie' => 'nullable|string',
            'lignes.*.operateur' => 'nullable|string',
            'lignes.*.data' => 'nullable|string',
            'lignes.*.international' => 'boolean',
            'lignes.*.option_facultative' => 'boolean',
            'lignes.*.sim' => 'nullable|string',
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
