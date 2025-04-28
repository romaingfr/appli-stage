<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            // Informations site
            $table->string('name_boite');
            $table->string('siret', 14);
            $table->string('forme_juridique');
            $table->string('code_naf');
            $table->string('mobile')->nullable()->after('localite');

            // Adresse
            $table->string('adresse_siege');
            $table->string('code_postal');
            $table->string('localite');
            $table->string('code_insee');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('mobile');
        });
    }
}
