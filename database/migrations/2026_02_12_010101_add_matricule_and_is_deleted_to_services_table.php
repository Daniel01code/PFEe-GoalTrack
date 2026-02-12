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
        Schema::table('services', function (Blueprint $table) {
            // Matricule unique et nullable (ex: SERV-2025-001)
            $table->string('matricule', 20)->unique()->nullable()->after('nom');

            // Flag soft delete (0 = actif, 1 = supprimé)
            $table->boolean('is_deleted')->default(false)->after('matricule');

            // Index pour accélérer les recherches sur matricule
            $table->index('matricule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('matricule');
            $table->dropColumn('is_deleted');
        });
    }
};