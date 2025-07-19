<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImportSqlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $path = database_path('projet-rh.sql');

        if (File::exists($path)) {
            DB::unprepared(File::get($path));
            echo "✅ Fichier SQL importé avec succès.\n";
        } else {
            echo "❌ Le fichier import.sql est introuvable.\n";
        }
    }
}
