<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalle del Activo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- CSS externo para show -->
    <link href="{{ asset('css/activo-show.css') }}" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
                <h4 class="mb-0"><i class="bi bi-card-list me-2"></i>Detalle del Activo</h4>
                <a href="{{ route('activos.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
            <div class="card-body">
                @php
                    $nivelRaw = $activo->nivel_riesgo ?? '';
                    $nivel = trim(mb_strtolower($nivelRaw, 'UTF-8'));

                    $badgeMap = [
                        'muy bajo'     => ['class' => 'bg-success text-white', 'icon' => 'bi-check-circle-fill', 'tooltip' => 'Riesgo mínimo, control efectivo.'],
                        'bajo'         => ['class' => 'bg-success bg-opacity-75 text-dark', 'icon' => 'bi-check-circle', 'tooltip' => 'Riesgo bajo, monitorear regularmente.'],
                        'moderado'     => ['class' => 'bg-primary text-white', 'icon' => 'bi-exclamation-circle-fill', 'tooltip' => 'Riesgo moderado, revisar medidas preventivas.'],
                        'medio'        => ['class' => 'bg-info text-white', 'icon' => 'bi-info-circle-fill', 'tooltip' => 'Riesgo medio, revisar medidas.'],
                        'medio-alto'   => ['class' => 'bg-warning text-dark', 'icon' => 'bi-exclamation-triangle-fill', 'tooltip' => 'Riesgo medio-alto, planificar acciones.'],
                        'alto'         => ['class' => 'bg-danger bg-opacity-75 text-white', 'icon' => 'bi-fire', 'tooltip' => 'Riesgo alto, aplicar acciones inmediatas.'],
                        'muy alto'     => ['class' => 'bg-danger text-white', 'icon' => 'bi-broadcast-pin', 'tooltip' => 'Riesgo muy alto, tomar precauciones fuertes.'],
                        'crítico'      => ['class' => 'bg-danger', 'icon' => 'bi-x-circle-fill', 'tooltip' => 'Riesgo crítico, atención prioritaria.'],
                        'critico'      => ['class' => 'bg-danger', 'icon' => 'bi-x-circle-fill', 'tooltip' => 'Riesgo crítico, atención prioritaria.'],
                        'extremo'      => ['class' => 'bg-dark text-white', 'icon' => 'bi-skull-fill', 'tooltip' => 'Riesgo extremo, actuar inmediatamente.'],
                    ];

                    $badge = $badgeMap[$nivel] ?? ['class' => 'bg-secondary text-white', 'icon' => 'bi-question-circle-fill', 'tooltip' => 'Nivel de riesgo no definido.'];
                @endphp

                {{-- Sección Información básica --}}
                <div class="section-card">
                    <h5 class="section-title"><i class="bi bi-info-circle me-1"></i>Información Básica</h5>
                    <table class="data-table">
                        <tbody>
                            <tr><th>Identificador Riesgo:</th><td>{{ $activo->identificador_riesgo ?? '-' }}</td></tr>
                            <tr><th>Nombre:</th><td>{{ $activo->nombre_activo ?? '-' }}</td></tr>
                            <tr><th>Tipo:</th><td>{{ $activo->tipo_activo ?? '-' }}</td></tr>
                            <tr><th>Propietario:</th><td>{{ $activo->propietario ?? '-' }}</td></tr>
                            <tr><th>Ubicación:</th><td>{{ $activo->ubicacion ?? '-' }}</td></tr>
                        </tbody>
                    </table>
                </div>

                {{-- Sección Seguridad --}}
                <div class="section-card">
                    <h5 class="section-title"><i class="bi bi-shield-lock me-1"></i>Seguridad</h5>
                    <table class="data-table">
                        <tbody>
                            <tr><th>Confidencialidad:</th><td>{{ $activo->confidencialidad ?? '-' }}</td></tr>
                            <tr><th>Integridad:</th><td>{{ $activo->integridad ?? '-' }}</td></tr>
                            <tr><th>Disponibilidad:</th><td>{{ $activo->disponibilidad ?? '-' }}</td></tr>
                        </tbody>
                    </table>
                </div>

                {{-- Sección Valoración y riesgo --}}
                <div class="section-card">
                    <h5 class="section-title"><i class="bi bi-exclamation-octagon me-1"></i>Valoración y Riesgo</h5>
                    <table class="data-table">
                        <tbody>
                            <tr><th>VA:</th><td>{{ $activo->va ?? '-' }}</td></tr>
                            <tr><th>Interpretación VA:</th><td>{{ $activo->va_interpretacion ?? '-' }}</td></tr>
                            <tr><th>Acción VA:</th><td>{{ $activo->va_accion ?? '-' }}</td></tr>
                            <tr><th>Amenaza:</th><td>{{ $activo->amenaza ?? '-' }}</td></tr>
                            <tr><th>Probabilidad:</th><td>{{ $activo->probabilidad ?? '-' }}</td></tr>
                            <tr><th>Impacto:</th><td>{{ $activo->impacto ?? '-' }}</td></tr>
                            <tr><th>Riesgo:</th><td>{{ $activo->riesgo ?? '-' }}</td></tr>
                            <tr>
                                <th>Nivel de Riesgo:</th>
                                <td>
                                    <span
                                        class="badge badge-large rounded-pill {{ $badge['class'] }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="{{ $badge['tooltip'] }}">
                                        <i class="bi {{ $badge['icon'] }} me-1"></i> {{ $activo->nivel_riesgo ?: '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr><th>Tratamiento:</th><td>{{ $activo->tratamiento ?? '-' }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS externo para show -->
    <script src="{{ asset('js/activo-show.js') }}"></script>
</body>
</html>
