<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trabajos_artes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('alumno_id'); // Cambiado a unsignedBigInteger simple
            $table->string('curso');
            $table->string('titulo_trabajo');
            $table->string('qr_token')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajos_artes');
    }
};