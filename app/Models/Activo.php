<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\ActivoService;

class Activo extends Model
{
    protected $table = 'activos_riesgo';

    protected $fillable = [
        'identificador_riesgo',
        'nombre_activo',
        'tipo_activo',
        'propietario',
        'ubicacion',
        'confidencialidad',
        'integridad',
        'disponibilidad',
        'va',
        'amenaza',
        'probabilidad',
        'impacto',
        'riesgo',
        'nivel_riesgo',
        'tratamiento',
        'va_interpretacion',
        'va_accion',
    ];

    // Instancia el servicio solo una vez para reutilizar
    protected $activoService;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->activoService = new ActivoService();
    }

    public function getVaAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        $result = $this->activoService->calcularVA(
            $this->confidencialidad,
            $this->integridad,
            $this->disponibilidad
        );

        return $result['va'];
    }

    public function getVaInterpretacionAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        $result = $this->activoService->calcularVA(
            $this->confidencialidad,
            $this->integridad,
            $this->disponibilidad
        );

        return $result['interpretacion'];
    }

    public function getVaAccionAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        $result = $this->activoService->calcularVA(
            $this->confidencialidad,
            $this->integridad,
            $this->disponibilidad
        );

        return $result['accion'];
    }

    public function getRiesgoAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        return $this->probabilidad * $this->impacto;
    }

    public function getNivelRiesgoAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        $result = $this->activoService->calcularRiesgo(
            $this->probabilidad,
            $this->impacto
        );

        return $result['nivel'];
    }

    public function getTratamientoAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        $result = $this->activoService->calcularRiesgo(
            $this->probabilidad,
            $this->impacto
        );

        return $result['tratamiento'];
    }
}
