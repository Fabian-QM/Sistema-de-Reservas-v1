<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->string('deporte', 50)->after('recinto_id')->nullable();
            $table->string('region', 100)->after('direccion')->nullable();
            $table->string('comuna', 100)->after('region')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn(['deporte', 'region', 'comuna']);
        });
    }
};