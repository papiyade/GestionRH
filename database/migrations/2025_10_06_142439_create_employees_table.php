<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('adresse');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('residence_actuelle');
            $table->string('certificat_residence')->nullable();
            $table->string('photocopie_identite')->nullable();
            $table->string('extrait_naissance')->nullable();
            $table->string('fiche_dotation_materiels')->nullable();
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('certificat_mariage')->nullable();
            $table->json('extraits_naissance_enfants')->nullable();
            $table->string('fiche_poste');
            $table->enum('statut', ['en_attente', 'validé', 'rejeté'])->default('en_attente');
            $table->timestamps();
        });

        Schema::create('salaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('salaire_base', 10, 2);
            $table->decimal('prime', 10, 2)->default(0);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->date('date_effet');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salaires');
        Schema::dropIfExists('employees');
    }
};