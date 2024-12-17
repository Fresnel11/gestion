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
        Schema::table('users', function (Blueprint $table) {
            // Supprimer le champ `username`
            $table->dropColumn('username');
            
            // Ajouter les champs `firstname` et `lastname`
            $table->string('firstname')->after('id'); // Ajouter après l'id
            $table->string('lastname')->after('firstname'); // Ajouter après firstname
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restaurer le champ `username`
            $table->string('username')->unique()->after('id');
            
            // Supprimer les champs `firstname` et `lastname`
            $table->dropColumn(['firstname', 'lastname']);
        });
    }
};
