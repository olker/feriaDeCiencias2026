<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones_invitados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trabajo_arte_id');
            $table->unsignedTinyInteger('estrellas');
            $table->string('ip_invitado')->nullable();
            $table->timestamps();

            $table->foreign('trabajo_arte_id')->references('id')->on('trabajos_artes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones_invitados');
    }
};