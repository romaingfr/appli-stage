<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteServicesTable extends Migration
{
    public function up()
    {
        Schema::create('site_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->boolean('is_principal')->default(false);
            // Téléphonie hébergée
            $table->boolean('svi')->default(false);
            $table->integer('channel_count')->default(0);
            // Liens d'accès
            $table->json('access_links')->nullable();
            $table->json('mobile_lines')->nullable();
            $table->boolean('cloud')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_services');
    }
}
