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
        Schema::create('candidatures', function (Blueprint $table) {
        $table->id();
    $table->foreignId('job_offer_id')->constrained('job_offers')->onDelete('cascade');

    $table->string('prenom');
    $table->string('nom');
    $table->string('email');
    $table->string('telephone');
    $table->string('linkedin')->nullable();

    $table->string('cv_path');
    $table->string('lettre_path')->nullable();
    $table->text('message')->nullable();
    $table->string('disponibilite')->nullable();
    $table->string('pretention')->nullable();

    $table->string('status_demande')->default('En attente');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
