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
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->integer('numero_carte');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->date('date_de_naissance');
            $table->string('lieu_de_naissance');
            $table->string("cin", 12)->nullable();
            $table->string('genre');
            $table->string('contact_personnel');
            $table->string('contact_tutaire');
            $table->boolean("sympathisant");
            $table->integer('fonctions_id');
            $table->integer('filieres_id');
            $table->integer('niveau_id');
            $table->string('adresse');
            $table->integer('users_id')->comment('Identifiant user authentifier');
            $table->integer('user_membre_id')->nullable();
            $table->string('facebook')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membres');
    }
};
