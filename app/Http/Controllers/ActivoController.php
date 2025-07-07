<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Http\Requests\StoreActivoRequest;
use App\Services\ActivoService;
use Illuminate\Http\RedirectResponse;

class ActivoController extends Controller
{
    protected $activoService;

    public function __construct(ActivoService $activoService)
    {
        $this->activoService = $activoService;
    }

    public function index()
    {
        $activos = Activo::orderBy('riesgo', 'desc')->get();
        return view('activos.index', compact('activos'));
    }

    public function create()
    {
        return view('activos.create');
    }

    public function store(StoreActivoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $vaData = $this->activoService->calcularVA(
            $data['confidencialidad'], $data['integridad'], $data['disponibilidad']
        );

        if ($request->filled('va') && $request->va != $vaData['va']) {
            return back()->withErrors(['va' => 'El Valor del Activo no coincide...'])->withInput();
        }

        $riesgoData = $this->activoService->calcularRiesgo(
            $data['probabilidad'], $data['impacto']
        );

        if ($request->filled('riesgo') && $request->riesgo != $riesgoData['riesgo']) {
            return back()->withErrors(['riesgo' => 'El Riesgo no coincide...'])->withInput();
        }

        if ($request->filled('nivel_riesgo') && $request->nivel_riesgo !== $riesgoData['nivel']) {
            return back()->withErrors(['nivel_riesgo' => 'El Nivel de Riesgo no coincide...'])->withInput();
        }

        if ($request->filled('tratamiento') && $request->tratamiento !== $riesgoData['tratamiento']) {
            return back()->withErrors(['tratamiento' => 'El Tratamiento no coincide...'])->withInput();
        }

        $ultimo = Activo::latest('id')->first();
        $identificador = $ultimo ? 'R-' . str_pad($ultimo->id + 1, 2, '0', STR_PAD_LEFT) : 'R-01';

        Activo::create([
            'identificador_riesgo' => $identificador,
            'nombre_activo' => $data['nombre_activo'],
            'tipo_activo' => $data['tipo_activo'],
            'propietario' => $data['propietario'],
            'ubicacion' => $data['ubicacion'],
            'confidencialidad' => $data['confidencialidad'],
            'integridad' => $data['integridad'],
            'disponibilidad' => $data['disponibilidad'],
            'va' => $vaData['va'],
            'va_interpretacion' => $vaData['interpretacion'],
            'va_accion' => $vaData['accion'],
            'amenaza' => $data['amenaza'],
            'probabilidad' => $data['probabilidad'],
            'impacto' => $data['impacto'],
            'riesgo' => $riesgoData['riesgo'],
            'nivel_riesgo' => $riesgoData['nivel'],
            'tratamiento' => $riesgoData['tratamiento'],
        ]);

        return redirect()->route('activos.index')->with('success', 'Activo creado exitosamente.');
    }

    public function show($id)
    {
        $activo = Activo::findOrFail($id);
        return view('activos.show', compact('activo'));
    }

    public function destroy($id)
    {
        $activo = Activo::findOrFail($id);
        $activo->delete();
        return redirect()->route('activos.index')->with('success', 'Activo eliminado correctamente.');
    }
}
