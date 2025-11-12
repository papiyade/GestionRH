<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            // Rubrique salaire
            $table->decimal('sursalaire', 10, 2)->nullable();
            $table->decimal('indemnite', 10, 2)->nullable();

            // Rubrique soumise
            $table->decimal('ipres_salariale', 5, 2)->default(5.6);
            $table->decimal('ipres_patronale', 5, 2)->default(8.4);
            $table->decimal('ipresc_salariale', 5, 2)->nullable();
            $table->decimal('ipresc_patronale', 5, 2)->nullable();
            $table->decimal('caisse_css', 10, 2)->nullable();
            $table->decimal('accident_travail', 5, 2)->nullable();
            $table->decimal('prestation_famille', 5, 2)->default(7);
            $table->decimal('ipm_assurance', 10, 2)->nullable();
            $table->decimal('ir', 10, 2)->nullable();
            $table->decimal('trimf', 10, 2)->nullable();
            $table->decimal('cfce', 5, 2)->default(3);

            // Rubrique non soumise
            $table->decimal('indemnite_transport', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            $table->dropColumn([
                'sursalaire', 'indemnite', 'ipres_salariale', 'ipres_patronale',
                'ipresc_salariale', 'ipresc_patronale', 'caisse_css',
                'accident_travail', 'prestation_famille', 'ipm_assurance',
                'ir', 'trimf', 'cfce', 'indemnite_transport',
            ]);
        });
    }
};
