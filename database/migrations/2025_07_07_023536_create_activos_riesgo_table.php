<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('activos_riesgo', function (Blueprint $table) {
        $table->id();
        $table->string('identificador_riesgo');
        $table->string('nombre_activo');
        $table->string('tipo_activo');
        $table->string('propietario');
        $table->string('ubicacion');
        $table->integer('confidencialidad');
        $table->integer('integridad');
        $table->integer('disponibilidad');
        $table->integer('va')->nullable(); // puede ser calculado
        $table->string('amenaza');
        $table->integer('probabilidad');
        $table->integer('impacto');
        $table->integer('riesgo')->nullable(); // puede ser calculado
        $table->string('nivel_riesgo')->nullable();
        $table->text('tratamiento')->nullable();
        $table->string('va_interpretacion')->nullable();
        $table->string('va_accion')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('activos_riesgo');
    }

};
