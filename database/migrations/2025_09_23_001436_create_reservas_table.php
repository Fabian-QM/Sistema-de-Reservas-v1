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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recinto_id')->constrained('recintos')->onDelete('cascade');
            $table->string('rut', 12);
            $table->string('nombre_organizacion', 255);
            $table->string('representante_nombre', 255);
            $table->string('email', 255);
            $table->string('email_confirmacion', 255); // Para validar que coincidan
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->integer('cantidad_personas');
            $table->date('fecha_reserva');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->foreignId('aprobada_por')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('acepta_reglamento')->default(false);
            $table->timestamps();
            
            // Índices para mejorar performance
            $table->index(['fecha_reserva', 'recinto_id']);
            $table->index('estado');
            $table->index('rut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
