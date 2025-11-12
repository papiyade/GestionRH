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
        Schema::table('cras', function (Blueprint $table) {
            // Ajouter les nouveaux champs s'ils n'existent pas
            if (!Schema::hasColumn('cras', 'bien_fonctionne')) {
                $table->text('bien_fonctionne')->nullable()->after('activites');
            }
            
            if (!Schema::hasColumn('cras', 'pas_bien_fonctionne')) {
                $table->text('pas_bien_fonctionne')->nullable()->after('bien_fonctionne');
            }
            
            if (!Schema::hasColumn('cras', 'points_durs')) {
                $table->text('points_durs')->nullable()->after('pas_bien_fonctionne');
            }
            
            if (!Schema::hasColumn('cras', 'next_steps')) {
                $table->text('next_steps')->nullable()->after('points_durs');
            }
            
            if (!Schema::hasColumn('cras', 'team_id')) {
                $table->unsignedBigInteger('team_id')->nullable()->after('user_id');
                $table->foreign('team_id')
                      ->references('id')
                      ->on('teams')
                      ->onDelete('cascade');
            }
            
            // Ajouter des indices pour les performances
            if (!Schema::hasColumn('cras', 'date_debut') || !Schema::getConnection()->getSchemaBuilder()->hasIndex('cras', 'idx_user_date')) {
                $table->index(['user_id', 'date_debut'], 'idx_user_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cras', function (Blueprint $table) {
            // Supprimer les champs ajoutés
            if (Schema::hasColumn('cras', 'bien_fonctionne')) {
                $table->dropColumn('bien_fonctionne');
            }
            
            if (Schema::hasColumn('cras', 'pas_bien_fonctionne')) {
                $table->dropColumn('pas_bien_fonctionne');
            }
            
            if (Schema::hasColumn('cras', 'points_durs')) {
                $table->dropColumn('points_durs');
            }
            
            if (Schema::hasColumn('cras', 'next_steps')) {
                $table->dropColumn('next_steps');
            }
            
            if (Schema::hasColumn('cras', 'team_id')) {
                $table->dropForeign(['team_id']);
                $table->dropColumn('team_id');
            }
            
            if (Schema::hasIndexes('cras') && Schema::hasIndex('cras', 'idx_user_date')) {
                $table->dropIndex('idx_user_date');
            }
        });
    }
};