<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar; // Importez le PermissionRegistrar

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Récupérer les noms de tables depuis la configuration du package
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        // Créer la table role_user
        if (!Schema::hasTable('role_user')) {
            Schema::create('role_user', function (Blueprint $table) {
                $table->foreignId('role_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->primary(['role_id', 'user_id']);
            });
        }

        // Créer la table roles
        if (!Schema::hasTable($tableNames['roles'])) {
            Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
                $table->bigIncrements('id');
                if ($teams || config('permission.testing')) {
                    $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                    $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
                }
                $table->string('name', 191); // Longueur réduite à 191
                $table->string('guard_name', 191); // Longueur réduite à 191
                $table->timestamps();
                if ($teams || config('permission.testing')) {
                    $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
                } else {
                    $table->unique(['name', 'guard_name']);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Récupérer les noms de tables depuis la configuration du package
        $tableNames = config('permission.table_names');

        // Supprimer les tables
        Schema::dropIfExists('role_user');
        Schema::dropIfExists($tableNames['roles']);
    }
};