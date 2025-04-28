<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Site;
use Illuminate\Database\Seeder;

class SecondarySitesTableSeeder extends Seeder
{
    public function run()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            Site::create([
                'client_id' => $client->id,
                'name_boite' => 'Site Secondaire - ' . $client->name,
                'adresse_siege' => '456 avenue exemple',
                'code_postal' => '69000',
                'localite' => 'Lyon',
                'principal' => false,
                'siret' => '98765432101234',
                'forme_juridique' => 'SAS',
                'code_naf' => '6202A',
                'code_insee' => '69123'
            ]);
        }
    }
}
