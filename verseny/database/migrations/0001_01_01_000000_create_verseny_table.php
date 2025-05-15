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
        Schema::create('verseny', function (Blueprint $table) {
            $table->id();
            $table->string('verseny_nev');
            $table->string('verseny_ev');
            $table->string('verseny_terulet');
            $table->text('verseny_leiras');
            $table->unique(['verseny_nev', 'verseny_ev']);
            $table->timestamps();
        });
        Schema::create('rounds',function(Blueprint $table){
            $table->id();
            $table->foreignId('verseny_id')->constrained('verseny')->onDelete('cascade');
            $table->date('kor_datum');
            $table->timestamps();
        });
        Schema::create('participants', function (Blueprint $table) {
            $table->foreignId('round_id')->constrained('rounds')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unique(['round_id','user_id']);
        });



        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('languages_pairs', function (Blueprint $table) {
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->foreignId('verseny_id')->constrained('verseny')->onDelete('cascade');
            $table->unique(['verseny_id','language_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void

    {
        Schema::dropIfExists('languages_pairs');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('participants');
        Schema::dropIfExists('rounds');
        Schema::dropIfExists('verseny');
    }
};
