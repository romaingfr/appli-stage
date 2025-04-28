<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('site_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('svi')->default(false);
            $table->integer('channel_count')->nullable();
            $table->boolean('cloud')->default(false);
            $table->text('access_links')->nullable();
            $table->text('mobile_lines')->nullable();
            $table->json('configuration')->nullable(); // Nouvelle colonne
            $table->json('lignes')->nullable(); // Nouvelle colonne
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
