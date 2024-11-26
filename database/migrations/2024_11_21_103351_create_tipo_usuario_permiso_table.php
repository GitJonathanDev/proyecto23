<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoUsuarioPermisoTable extends Migration
{
    public function up(): void
    {
        Schema::create('tipoUsuarioPermiso', function (Blueprint $table) {
            $table->foreignId('codTipoUsuarioF')->constrained('TipoUsuario', 'codTipoUsuario')->onDelete('cascade');
            $table->foreignId('codPermisoF')->constrained('permiso', 'codPermiso')->onDelete('cascade');
            $table->primary(['codTipoUsuarioF', 'codPermisoF']); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipoUsuarioPermiso');
    }
}
