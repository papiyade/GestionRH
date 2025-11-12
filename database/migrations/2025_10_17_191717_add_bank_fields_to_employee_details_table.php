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
    Schema::table('employee_details', function (Blueprint $table) {
        $table->string('banque_nom')->nullable();
        $table->string('iban')->nullable();
        $table->string('bic_swift')->nullable();
        $table->string('numero_compte')->nullable();
        $table->string('type_compte')->nullable();
        $table->string('nom_titulaire')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            //
        });
    }
};
