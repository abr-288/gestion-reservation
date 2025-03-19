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
        // Si la colonne 'nom' existe déjà et vous souhaitez la modifier, vous pouvez utiliser :
        $table->string('nom', 191)->nullable()->change(); // Par exemple, rendre la colonne nullable si besoin
    });
}

public function down()
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->dropColumn('nom'); // Si vous voulez revenir en arrière et supprimer la colonne
    });
}

};
