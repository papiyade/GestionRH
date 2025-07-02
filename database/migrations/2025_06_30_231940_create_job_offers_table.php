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
        Schema::create('job_offers', function (Blueprint $table) {
              $table->id();

            $table->foreignId('entreprise_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('titre');
            $table->string('equipe');
            $table->string('secteur')->nullable(); // Ex: Informatique, Finance
            $table->text('description');
            $table->string('type_contrat'); // CDI, CDD, etc.
            $table->date('date_limite');

            $table->integer('salaire')->nullable();
            $table->string('devise')->nullable(); // XOF, EUR, etc.
            $table->string('periode_salaire')->nullable(); // mensuel, annuel, etc.

            $table->string('experience_requise');
            $table->string('statut'); // En cours, Clôturé, Annulé
            $table->boolean('teletravail')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
