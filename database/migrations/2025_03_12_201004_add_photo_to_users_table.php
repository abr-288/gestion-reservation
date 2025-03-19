<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoToUsersTable extends Migration
{
    /**
     * Exécuter la migration.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('email'); // Ajouter la colonne `photo`
        });
    }

    /**
     * Annuler la migration.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo'); // Supprimer la colonne `photo`
        });
    }
}