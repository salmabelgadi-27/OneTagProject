<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modele3ds', function (Blueprint $table) {
            $table->id();
            $table->string('nom_fichier');
            $table->string('format')->default('glb');
            $table->float('taille_originale');
            $table->string('chemin_stockage');
            $table->boolean('est_compresse')->default(false);
            $table->string('url_hebergement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modele3ds');
    }
};