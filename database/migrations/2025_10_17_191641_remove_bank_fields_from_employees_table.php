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
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn([
            'banque_nom',
            'iban',
            'bic_swift',
            'numero_compte',
            'type_compte',
            'nom_titulaire',
        ]);
    });
}

public function down(): void
{
    Schema::table('employees', function (Blueprint $table) {
        $table->string('banque_nom')->nullable();
        $table->string('iban')->nullable();
        $table->string('bic_swift')->nullable();
        $table->string('numero_compte')->nullable();
        $table->string('type_compte')->nullable();
        $table->string('nom_titulaire')->nullable();
    });
}

};
