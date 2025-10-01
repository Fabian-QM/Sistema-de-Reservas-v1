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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'jefe_recintos', 'encargado_recinto'])
                  ->default('admin')
                  ->after('email_verified_at');
            $table->foreignId('recinto_asignado_id')
                  ->nullable()
                  ->constrained('recintos')
                  ->onDelete('set null')
                  ->after('role');
            $table->boolean('activo')->default(true)->after('recinto_asignado_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['recinto_asignado_id']);
            $table->dropColumn(['role', 'recinto_asignado_id', 'activo']);
        });
    }
};
