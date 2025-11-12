<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            if (Schema::hasColumn('employee_details', 'indemnite')) {
                $table->dropColumn('indemnite');
            }
            if (Schema::hasColumn('employee_details', 'indemnite_transport')) {
                $table->dropColumn('indemnite_transport');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            $table->decimal('indemnite', 10, 2)->nullable();
            $table->decimal('indemnite_transport', 10, 2)->nullable();
        });
    }
};
