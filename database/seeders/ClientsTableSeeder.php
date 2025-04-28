<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    public function run(): void
    {
        Client::create([
            'name_boite' => 'Entreprise Test',
            'siret' => '12345678901234',
            'forme_juridique' => 'SARL',
            'code_naf' => '6201Z',
            'nom_client' => 'Dupont',
            'prenom_client' => 'Jean',
            'numero_telephone' => '0123456789',
            'numero_mobile' => '0612345678',
            'email' => 'contact@entreprise-test.fr',
            'adresse_siege' => '123 rue du Test',
            'code_postal' => '75001',
            'localite' => 'Paris',
            'code_insee' => '75101',
            'nom_facturation' => 'Dupont',
            'prenom_facturation' => 'Jean',
            'telephone_facturation' => '0123456789',
            'adresse_facturation' => '123 rue du Test',
            'code_postal_facturation' => '75001',
            'ville_facturation' => 'Paris'
        ]);
    }
}
