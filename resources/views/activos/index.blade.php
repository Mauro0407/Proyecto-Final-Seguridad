<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inventario de Activos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <!-- CSS personalizado -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Inventario de Activos</h4>
                <a href="{{ route('activos.create') }}" class="btn btn-success btn-sm" aria-label="Agregar nuevo activo">
                    <i class="bi bi-plus-lg"></i> Agregar Activo
                </a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                @if($activos->isEmpty())
                    <div class="alert alert-info text-center mb-0">No hay activos registrados.</div>
                @else
                    <div class="table-responsive">
                        <table id="activosTable" class="table table-striped table-hover table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Riesgo</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Propietario</th>
                                    <th>Nivel Riesgo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activos as $activo)
                                    @php
                                        // Normalizar nivel de riesgo para evitar mayúsculas, espacios y tildes
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
                                    <tr>
                                        <td>{{ $activo->identificador_riesgo ?? '-' }}</td>
                                        <td class="text-start">{{ $activo->nombre_activo }}</td>
                                        <td>{{ $activo->tipo_activo }}</td>
                                        <td>{{ $activo->propietario }}</td>
                                        <td>
                                            <span
                                                class="badge rounded-pill {{ $badge['class'] }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="{{ $badge['tooltip'] }}">
                                                <i class="bi {{ $badge['icon'] }} me-1"></i> {{ $activo->nivel_riesgo ?: '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('activos.show', $activo->id) }}" class="btn btn-info btn-sm" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <form action="{{ route('activos.destroy', $activo->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('¿Estás seguro que deseas eliminar este activo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JS externos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- JS personalizado -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
