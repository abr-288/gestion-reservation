<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('nom')->default(''); // Valeur par défaut vide
            $table->string('prenom', 191)->nullable()->default(null)->change(); // Nullable et valeur par défaut null
            $table->string('type_document');
            $table->string('numero_document');
            $table->string('PNR')->default(''); // Valeur par défaut vide
            $table->enum('type_voyage', ['aller_simple', 'aller_retour'])->default('aller_simple'); // Valeur par défaut aller_simple
            $table->date('date_voyage_aller')->nullable()->default(null); // Nullable et valeur par défaut null
            $table->date('date_voyage_retour')->nullable()->default(null); // Nullable et valeur par défaut null
            $table->date('date_annulation')->nullable()->default(null); // Nullable et valeur par défaut null
            $table->string('numero_client')->nullable()->default(null); // Nullable et valeur par défaut null
            $table->decimal('prix_billet', 8, 2)->nullable()->default(null); // Nullable et valeur par défaut null
            $table->string('nom_agent')->nullable()->default(null); // Nullable et valeur par défaut null
            $table->string('statut')->default('en_attente'); // Valeur par défaut 'en_attente'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
