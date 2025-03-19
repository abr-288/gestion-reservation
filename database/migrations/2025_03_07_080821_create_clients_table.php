<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientsTableWithDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('nom')->default('Nom par défaut');
            $table->string('prenom')->default('Prénom par défaut');
            $table->string('type_document')->default('Carte nationale d\'identité');
            $table->string('numero_document')->default('XXXX-XXXX');
            $table->string('PNR')->default('PNR-0000');
            $table->string('type_voyage')->default('aller_retour');
            $table->date('date_voyage_aller')->default(now());
            $table->date('date_voyage_retour')->nullable()->default(null);
            $table->date('date_annulation')->nullable()->default(null);
            $table->string('numero_client')->default('NC-0000');
            $table->decimal('prix_billet', 8, 2)->default(0.00);
            $table->string('nom_agent')->default('Agent non attribué');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('nom');
            $table->dropColumn('prenom');
            $table->dropColumn('type_document');
            $table->dropColumn('numero_document');
            $table->dropColumn('PNR');
            $table->dropColumn('type_voyage');
            $table->dropColumn('date_voyage_aller');
            $table->dropColumn('date_voyage_retour');
            $table->dropColumn('date_annulation');
            $table->dropColumn('numero_client');
            $table->dropColumn('prix_billet');
            $table->dropColumn('nom_agent');
        });
    }
}
