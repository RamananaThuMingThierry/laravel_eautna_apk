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

            $table->unsignedBigInteger('fonctions_id');
            $table->foreign('fonctions_id')->references('id')->on('fonctions')->onUpdate('cascade')->onDelete('cascade');
            
            $table->unsignedBigInteger('filieres_id');
            $table->foreign('filieres_id')->references('id')->on('filieres')->onUpdate('cascade')->onDelete('cascade');
            
            $table->unsignedBigInteger('levels_id');
            $table->foreign('levels_id')->references('id')->on('levels')->onUpdate('cascade')->onDelete('cascade');
            
            $table->unsignedBigInteger('axes_id');
            $table->foreign('axes_id')->references('id')->on('axes')->onUpdate('cascade')->onDelete('cascade');

            $table->string('adresse');

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            
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
