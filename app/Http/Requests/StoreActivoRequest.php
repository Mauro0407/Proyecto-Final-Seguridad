<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre_activo' => 'required|string|max:255',
            'tipo_activo' => 'required|string|max:255',
            'propietario' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'confidencialidad' => 'required|integer|between:1,5',
            'integridad' => 'required|integer|between:1,5',
            'disponibilidad' => 'required|integer|between:1,5',
            'amenaza' => 'required|string|max:255',
            'probabilidad' => 'required|integer|between:1,5',
            'impacto' => 'required|integer|between:1,5',
            'va' => 'nullable|integer|between:3,15',
            'riesgo' => 'nullable|integer|between:1,25',
            'nivel_riesgo' => 'nullable|in:Muy Bajo,Bajo,Moderado,Alto,Muy Alto,Crítico,Extremo',
            'tratamiento' => 'nullable|string|max:255',
        ];
    }
}
