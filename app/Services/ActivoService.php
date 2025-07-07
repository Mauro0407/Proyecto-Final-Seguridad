<?php

namespace App\Services;

class ActivoService
{
    public function calcularVA(int $c, int $i, int $d): array
    {
        $va = $c + $i + $d;
        $interpretacion = 'Bajo';
        $accion = 'Revisión anual';

        if ($va > 6 && $va <= 10) {
            $interpretacion = 'Medio';
            $accion = 'Monitoreo periódico y controles básicos';
        } elseif ($va > 10) {
            $interpretacion = 'Alto / Crítico';
            $accion = 'Alta prioridad en análisis de riesgos';
        }

        return compact('va', 'interpretacion', 'accion');
    }

    public function calcularRiesgo(int $probabilidad, int $impacto): array
    {
        $riesgo = $probabilidad * $impacto;

        if ($riesgo <= 3) {
            return ['nivel' => 'Muy Bajo', 'tratamiento' => 'Aceptar sin intervención', 'riesgo' => $riesgo];
        } elseif ($riesgo <= 6) {
            return ['nivel' => 'Bajo', 'tratamiento' => 'Monitoreo básico', 'riesgo' => $riesgo];
        } elseif ($riesgo <= 9) {
            return ['nivel' => 'Medio', 'tratamiento' => 'Monitoreo regular', 'riesgo' => $riesgo];
        } elseif ($riesgo <= 12) {
            return ['nivel' => 'Medio-Alto', 'tratamiento' => 'Tratar en mediano plazo', 'riesgo' => $riesgo];
        } elseif ($riesgo <= 16) {
            return ['nivel' => 'Alto', 'tratamiento' => 'Mitigar', 'riesgo' => $riesgo];
        } elseif ($riesgo <= 20) {
            return ['nivel' => 'Muy Alto', 'tratamiento' => 'Intervención urgente', 'riesgo' => $riesgo];
        } elseif ($riesgo <= 24) {
            return ['nivel' => 'Crítico', 'tratamiento' => 'Intervención urgente', 'riesgo' => $riesgo];
        } else {
            return ['nivel' => 'Extremo', 'tratamiento' => 'Medidas extremas', 'riesgo' => $riesgo];
        }
    }
}
