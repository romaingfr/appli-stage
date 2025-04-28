<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Site;
use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder
{
    public function run()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            // Supprime tous les sites existants pour ce client
            $client->sites()->delete();

            // Crée uniquement le site principal
            Site::create([
                'client_id' => $client->id,
                'name_boite' => 'Site Principal - ' . $client->name_boite,
                'adresse_siege' => $client->adresse_siege,
                'code_postal' => $client->code_postal,
                'localite' => $client->localite,
                'principal' => true,
                'siret' => $client->siret,
                'forme_juridique' => $client->forme_juridique,
                'code_naf' => $client->code_naf,
                'code_insee' => $client->code_insee
            ]);
        }
    }
}
