<?php
// Créez un fichier dans database/seeders/MigrateServiceDataSeeder.php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class MigrateServiceDataSeeder extends Seeder
{
    public function run()
    {
        $services = Service::all();
        foreach ($services as $service) {
            // Migration des colonnes individuelles vers configuration
            $service->configuration = [
                'svi' => (bool)$service->svi,
                'channel_count' => $service->channel_count,
                'cloud' => (bool)$service->cloud,
                'access_type' => '',  // Valeur par défaut
                'debit' => ''         // Valeur par défaut
            ];

            // Migration des données de mobile_lines/phone_lines vers lignes
            $lignes = [];

            // Ajoutez ici la logique pour convertir mobile_lines/phone_lines en format approprié

            $service->lignes = $lignes;
            $service->save();
        }
    }
}
