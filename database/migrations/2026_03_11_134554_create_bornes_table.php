<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bornes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('localisation');
            $table->enum('type_connecteur', ['Type1', 'Type2']);
            $table->float('puissance_kw');
            $table->enum('statut', ['disponible', 'occupee', 'maintenance'])->default('disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bornes');
    }
};
