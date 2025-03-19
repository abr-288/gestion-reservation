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
            if (!Schema::hasColumn('reservations', 'prenom')) {
                $table->string('prenom', 191)->after('nom'); // Si la colonne 'prenom' n'existe pas, alors on l'ajoute
            }
        });
    }
    
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (Schema::hasColumn('reservations', 'prenom')) {
                $table->dropColumn('prenom'); // Si la colonne 'prenom' existe, alors on la supprime
            }
        });
    }
    
};
