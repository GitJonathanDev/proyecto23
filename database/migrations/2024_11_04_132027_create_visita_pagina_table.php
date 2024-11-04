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
        Schema::create('visitaPagina', function (Blueprint $table) {
            $table->unsignedBigInteger('codUsuario'); 
            $table->unsignedBigInteger('codPagina');
            $table->primary(['codUsuario', 'codPagina']);
            $table->foreign('codUsuario')->references('codUsuario')->on('users');
            $table->foreign('codPagina')->references('id')->on('Pagina');
            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visita_pagina');
    }
};
