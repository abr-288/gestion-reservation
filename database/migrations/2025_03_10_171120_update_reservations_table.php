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
        Schema::table('reservations', function (Blueprint $table) {
            // Rendre la colonne 'prenom' nullable et ajouter une valeur par défaut
            $table->string('prenom', 191)->nullable()->default(null)->change();
            
            // Ajouter des valeurs par défaut à certains champs
            $table->string('nom')->default('')->change();
            $table->string('PNR')->default('')->change();
            $table->enum('type_voyage', ['aller_simple', 'aller_retour'])->default('aller_simple')->change();
            $table->date('date_voyage_aller')->nullable()->default(null)->change();
            $table->date('date_voyage_retour')->nullable()->default(null)->change();
            $table->date('date_annulation')->nullable()->default(null)->change();
            $table->string('numero_client')->nullable()->default(null)->change();
            $table->decimal('prix_billet', 8, 2)->nullable()->default(null)->change();
            $table->string('nom_agent')->nullable()->default(null)->change();
            $table->string('statut')->default('en_attente')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Revert changes if needed
            $table->string('prenom', 191)->nullable(false)->change();
            $table->string('nom')->nullable(false)->change();
            $table->string('PNR')->nullable(false)->change();
            $table->enum('type_voyage', ['aller_simple', 'aller_retour'])->nullable(false)->change();
            $table->date('date_voyage_aller')->nullable(false)->change();
            $table->date('date_voyage_retour')->nullable(false)->change();
            $table->date('date_annulation')->nullable(false)->change();
            $table->string('numero_client')->nullable(false)->change();
            $table->decimal('prix_billet', 8, 2)->nullable(false)->change();
            $table->string('nom_agent')->nullable(false)->change();
            $table->string('statut')->nullable(false)->change();
        });
    }
};
