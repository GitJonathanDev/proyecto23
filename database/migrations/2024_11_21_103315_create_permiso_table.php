<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisoTable extends Migration
{
    public function up(): void
    {
        Schema::create('permiso', function (Blueprint $table) {
            $table->bigIncrements('codPermiso');
            $table->foreignId('codOpcionF')->constrained('opcion', 'codOpcion')->onDelete('cascade');
            $table->string('accion'); // Ejemplo: crear, editar, eliminar, ver
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permiso');
    }
}
