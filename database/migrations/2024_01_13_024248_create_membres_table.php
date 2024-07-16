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
            $table->date('date_de_naissance')->nallable();
            $table->string('lieu_de_naissance')->nullable();
            $table->string("cin", 12)->nullable();
            $table->string('email')->nullable();
            $table->string('genre');
            $table->string('etablissement')->nullable();
            $table->string('contact_personnel');
            $table->string('contact_tuteur')->nullable();
            $table->boolean("sympathisant");
            $table->date('date_inscription');
            $table->unsignedBigInteger('sections_id');
            $table->foreign('sections_id')->references('id')->on('sections')->onUpdate('cascade');
            $table->unsignedBigInteger('fonctions_id');
            $table->foreign('fonctions_id')->references('id')->on('fonctions')->onUpdate('cascade');
            $table->unsignedBigInteger('filieres_id')->nullable();
            $table->foreign('filieres_id')->references('id')->on('filieres')->onUpdate('cascade');
            $table->unsignedBigInteger('levels_id')->nullable();
            $table->foreign('levels_id')->references('id')->on('levels')->onUpdate('cascade');
            $table->unsignedBigInteger('axes_id')->nullable();
            $table->foreign('axes_id')->references('id')->on('axes')->onUpdate('cascade');
            $table->string('adresse')->nullable();
            $table->string('facebook')->nullable();
            $table->softDeletes();
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
