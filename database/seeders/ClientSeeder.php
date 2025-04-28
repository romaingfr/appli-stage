<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Client::create([
            // Microsoft France
            'name_boite' => 'Microsoft France',
            'nom_client' => 'Guiffroy',
            'prenom_client' => 'Romain',
            'numero_telephone' => '01 57 75 10 00',
            'numero_mobile' => '06 12 34 56 78',
            'email' => 'guiffroyromain@gmail.com',
            'forme_juridique' => 'SAS',
            'adresse_siege' => '37 Quai du Président Roosevelt',
            'code_postal' => '92130',
            'localite' => 'Issy-les-Moulineaux',
            'code_insee' => '92040',
            'siret' => '32789923500017',
            'code_naf' => '5829C',
            // Données de facturation
            'nom_facturation' => 'Dupont',
            'prenom_facturation' => 'Marie',
            'telephone_facturation' => '01 57 75 10 01',
            'adresse_facturation' => '39 Quai du Président Roosevelt',
            'code_postal_facturation' => '92130',
            'ville_facturation' => 'Issy-les-Moulineaux'
        ]);

        \App\Models\Client::create([
            // Auchan Retail
            'name_boite' => 'Auchan Retail',
            'nom_client' => 'Caron',
            'prenom_client' => 'Hugo',
            'numero_telephone' => '01 30 81 20 00',
            'numero_mobile' => '06 12 34 56 78',
            'email' => 'caronhugo@gmail.com',
            'forme_juridique' => 'SAS',
            'adresse_siege' => '68 avenue de Flandre',
            'code_postal' => '75019',
            'localite' => 'Paris',
            'code_insee' => '75698',
            'siret' => '78071104200023',
            'code_naf' => '5610A',
            // Données de facturation
            'nom_facturation' => 'Martin',
            'prenom_facturation' => 'Pierre',
            'telephone_facturation' => '01 30 81 20 01',
            'adresse_facturation' => '70 avenue de Flandre',
            'code_postal_facturation' => '75019',
            'ville_facturation' => 'Paris'
        ]);
    }
}
