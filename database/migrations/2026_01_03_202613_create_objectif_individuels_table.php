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
        Schema::create('objectif_individuels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objectif_global_id')->constrained('objectif_globals')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('cible_personnelle');
            $table->decimal('pourcentage_atteinte', 5, 2)->default(0);
            $table->text('commentaire')->nullable();
            $table->enum('statut', ['assigne', 'atteint', 'partiel'])->default('assigne');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectif_individuels');
    }
};
