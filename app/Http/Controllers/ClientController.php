<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect()->route('clients.search');

    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_boite' => 'required|string|max:255',
            'forme_juridique' => 'required|string|max:255',
            'adresse_siege' => 'required|string',
            'code_postal' => 'required|string',
            'localite' => 'required|string',
            'code_insee' => 'nullable|string',
            'siret' => 'required|string|size:14|unique:clients',
            'code_naf' => 'required|string',
            'nom_client' => 'required|string|max:255',
            'prenom_client' => 'required|string|max:255',
            'numero_telephone' => 'nullable|string',
            'numero_mobile' => 'nullable|string',
            'email' => 'required|email',
            'nom_facturation' => 'required|string|max:255',
            'prenom_facturation' => 'required|string|max:255',
            'telephone_facturation' => 'nullable|string',
            'adresse_facturation' => 'required|string',
            'code_postal_facturation' => 'required|string',
            'ville_facturation' => 'required|string'
        ]);

        $client = Client::create($validated);

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Client créé avec succès');
    }

    public function show(Client $client)
    {
        $client->load('sites'); // Chargement des sites associés
        return view('clients.show', compact('client'));
    }

    public function showSite(Client $client, Site $site)
    {
        return view('clients.site', [
            'client' => $client,
            'site' => $site
        ]);
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name_boite' => 'required|string|max:255',
            'siret' => "required|string|size:14|unique:clients,siret,{$client->id}",
            'forme_juridique' => 'required|string|max:255',
            'code_naf' => 'required|string',
            'adresse_siege' => 'required|string',
            'code_postal' => 'required|string',
            'localite' => 'required|string',
            'code_insee' => 'required|string',
            'prenom_client' => 'required|string|max:255',
            'nom_client' => 'required|string|max:255',
            'email' => 'required|email',
            'numero_telephone' => 'nullable|string',
            'numero_mobile' => 'nullable|string',
            'prenom_facturation' => 'required|string|max:255',
            'nom_facturation' => 'required|string|max:255',
            'telephone_facturation' => 'nullable|string',
            'adresse_facturation' => 'required|string',
            'code_postal_facturation' => 'required|string',
            'ville_facturation' => 'required|string'
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Client mis à jour avec succès');
    }

    public function destroy(Client $client)
    {
        try {
            $client->delete();
            return redirect()
                ->route('clients.search')
                ->with('success', 'Client supprimé avec succès');
        } catch (\Exception $e) {
            return back()->with('error', 'Impossible de supprimer ce client');
        }
    }

    public function search(Request $request)
    {
        $query = Client::query();

        if ($request->filled('name_boite')) {
            $search = '%' . $request->input('name_boite') . '%';
            $query->where('name_boite', 'like', $search);
        }

        if ($request->filled('siret')) {
            $query->where('siret', $request->siret);
        }

        if ($request->filled('nom_client')) {
            $search = '%' . $request->input('nom_client') . '%';
            $query->where('nom_client', 'like', $search);
        }

        if ($request->filled('telephone')) {
            $searchTel = $request->input('telephone');
            // Supprime tous les espaces du numéro recherché
            $searchTel = str_replace(' ', '', $searchTel);

            $query->where(function($q) use ($searchTel) {
                // Pour chaque colonne de téléphone, on compare avec le numéro formaté
                $q->whereRaw('REPLACE(numero_telephone, " ", "") LIKE ?', ['%' . $searchTel . '%'])
                    ->orWhereRaw('REPLACE(numero_mobile, " ", "") LIKE ?', ['%' . $searchTel . '%'])
                    ->orWhereRaw('REPLACE(telephone_facturation, " ", "") LIKE ?', ['%' . $searchTel . '%']);
            });
        }

        $clients = $query->with('sites')
            ->orderBy('name_boite')
            ->paginate(10)
            ->withQueryString();

        return view('clients.search', compact('clients'));
    }

    public function exportSite(Client $client, $site)
    {
        try {
            \Log::info('Export demandé pour client ' . $client->id . ' et site ' . $site);

            $targetSite = $site === 'principal'
                ? $client->sites()->where('principal', true)->firstOrFail()
                : $client->sites()->findOrFail($site);

            $html = view('exports.site', [
                'client' => $client,
                'site' => $targetSite
            ])->render();

            $pdf = PDF::loadHTML($html);

            return $pdf->stream('test.pdf');
        } catch (\Exception $e) {
            \Log::error('Erreur export : ' . $e->getMessage());
            dd($e->getMessage()); // Affichage de l'erreur pour le débogage
        }
    }
    public function updateField(Request $request, Client $client)
    {
        $field = $request->field;
        $value = $request->value;

        // Vérifier que le champ existe dans le modèle
        if (!in_array($field, $client->getFillable())) {
            return response()->json(['message' => 'Champ non autorisé'], 422);
        }

        try {
            $client->$field = $value;
            $client->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
