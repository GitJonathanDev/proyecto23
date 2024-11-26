<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionTable extends Migration
{
    public function up(): void
    {
        Schema::create('opcion', function (Blueprint $table) {
            $table->bigIncrements('codOpcion');
            $table->string('nombre');
            $table->string('ruta');
            $table->string('icono')->nullable();
            $table->foreignId('codMenuF')->constrained('menu', 'codMenu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opcion');
    }
}

