<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('site_services', function (Blueprint $table) {
            $table->json('configuration')->nullable();
            $table->json('lignes')->nullable();
        });
    }

    public function down()
    {
        Schema::table('site_services', function (Blueprint $table) {
            $table->dropColumn(['configuration', 'lignes']);
        });
    }
};
