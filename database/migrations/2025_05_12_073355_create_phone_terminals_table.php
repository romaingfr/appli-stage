<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('phone_terminals', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('terminal_type');
            $table->string('serial_number')->unique();
            $table->boolean('is_available')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phone_terminals');
    }
};
