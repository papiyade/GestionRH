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
        Schema::create('employee_details', function (Blueprint $table) {
             $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('matricule')->unique(); // <-- ajout ici
        $table->decimal('salaire', 10, 2)->nullable();
        $table->string('type_contrat')->nullable();
        $table->text('description_poste')->nullable();
        $table->date('date_naissance')->nullable();
        $table->date('date_debut')->nullable();
        $table->date('date_fin')->nullable();
        $table->string('adresse')->nullable();
        $table->string('telephone')->nullable();
        $table->string('statut_employe')->default('actif');
        $table->string('genre')->nullable();
        $table->string('ville')->nullable();
        $table->string('nationalite')->nullable();
        $table->string('niveau_etude')->nullable();
        $table->text('experience')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_details');
    }
};
