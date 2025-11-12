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
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prestataire_id');
            $table->date('date'); // date de la prestation
            $table->decimal('montant', 15, 2);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreign('prestataire_id')->references('id')->on('prestataires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestations');
    }
};
