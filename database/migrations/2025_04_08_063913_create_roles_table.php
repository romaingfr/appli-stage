<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insertion des rôles de base
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'client'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
