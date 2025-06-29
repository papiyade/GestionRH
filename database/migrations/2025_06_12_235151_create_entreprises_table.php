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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('id_user');
            $table->string('logo_path')->nullable();
            $table->string('adresse')->nullable();
            $table->string('entreprise_name');
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_actif')->default(true);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
