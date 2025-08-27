<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('teams', function (Blueprint $table) {
        $table->unsignedBigInteger('pilot_id')->nullable()->after('owner_id');

        $table->foreign('pilot_id')
              ->references('id')
              ->on('users')
              ->onDelete('set null'); 
    });
}

public function down()
{
    Schema::table('teams', function (Blueprint $table) {
        $table->dropForeign(['pilot_id']);
        $table->dropColumn('pilot_id');
    });
}

};
