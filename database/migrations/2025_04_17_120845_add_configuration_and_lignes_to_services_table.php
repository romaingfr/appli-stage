<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'configuration')) {
                $table->json('configuration')->nullable();
            }

            if (!Schema::hasColumn('services', 'lignes')) {
                $table->json('lignes')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['configuration', 'lignes']);
        });
    }
};
