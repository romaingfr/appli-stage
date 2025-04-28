<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // Informations entreprise
            $table->string('name_boite');
            $table->string('siret', 14);
            $table->string('forme_juridique');
            $table->string('code_naf');

            // Contact principal
            $table->string('nom_client');
            $table->string('prenom_client');
            $table->string('numero_telephone')->nullable();
            $table->string('numero_mobile')->nullable();
            $table->string('email');

            // Adresse siège
            $table->string('adresse_siege');
            $table->string('code_postal');
            $table->string('localite');
            $table->string('code_insee')->nullable();

            // Adresse facturation
            $table->string('nom_facturation');
            $table->string('prenom_facturation');
            $table->string('telephone_facturation')->nullable();
            $table->string('adresse_facturation');
            $table->string('code_postal_facturation');
            $table->string('ville_facturation');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
