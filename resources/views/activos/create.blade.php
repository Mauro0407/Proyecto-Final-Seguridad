<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agregar Activo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- CSS personalizado -->
    <link href="{{ asset('css/activo-create.css') }}" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow rounded-4">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-square me-2"></i>Agregar Nuevo Activo
                        </h4>
                        <a href="{{ route('activos.index') }}" class="btn btn-success btn-sm d-flex align-items-center gap-1">
                            <i class="bi bi-arrow-left"></i> Volver al Inventario
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Corrige los siguientes errores:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        @endif

                        <form id="activoForm" action="{{ route('activos.store') }}" method="POST" novalidate>
                            @csrf
                            <div class="row g-4">
                                <!-- IZQUIERDA: Campos editables -->
                                <div class="col-md-6">
                                    @php
                                        $camposEditables = [
                                            ['name' => 'nombre_activo', 'label' => 'Nombre del Activo', 'type' => 'text', 'icon' => 'bi-card-text'],
                                            ['name' => 'tipo_activo', 'label' => 'Tipo de Activo', 'type' => 'text', 'icon' => 'bi-box-seam'],
                                            ['name' => 'propietario', 'label' => 'Propietario', 'type' => 'text', 'icon' => 'bi-person-badge'],
                                            ['name' => 'ubicacion', 'label' => 'Ubicación', 'type' => 'text', 'icon' => 'bi-geo-alt'],
                                            ['name' => 'confidencialidad', 'label' => 'Confidencialidad (1-5)', 'type' => 'number', 'min' => 1, 'max' => 5, 'icon' => 'bi-shield-lock'],
                                            ['name' => 'integridad', 'label' => 'Integridad (1-5)', 'type' => 'number', 'min' => 1, 'max' => 5, 'icon' => 'bi-check2-circle'],
                                            ['name' => 'disponibilidad', 'label' => 'Disponibilidad (1-5)', 'type' => 'number', 'min' => 1, 'max' => 5, 'icon' => 'bi-clock-history'],
                                            ['name' => 'amenaza', 'label' => 'Amenaza', 'type' => 'text', 'icon' => 'bi-exclamation-triangle-fill'],
                                            ['name' => 'probabilidad', 'label' => 'Probabilidad (1-5)', 'type' => 'number', 'min' => 1, 'max' => 5, 'icon' => 'bi-percent'],
                                            ['name' => 'impacto', 'label' => 'Impacto (1-5)', 'type' => 'number', 'min' => 1, 'max' => 5, 'icon' => 'bi-broadcast-pin'],
                                        ];
                                    @endphp

                                    @foreach ($camposEditables as $campo)
                                        <div class="mb-4">
                                            <label for="{{ $campo['name'] }}" class="form-label fw-semibold d-flex align-items-center gap-2">
                                                <i class="bi {{ $campo['icon'] }} fs-5 text-primary"></i> {{ $campo['label'] }}
                                            </label>
                                            <input
                                                type="{{ $campo['type'] }}"
                                                name="{{ $campo['name'] }}"
                                                id="{{ $campo['name'] }}"
                                                class="form-control @error($campo['name']) is-invalid @enderror"
                                                value="{{ old($campo['name']) }}"
                                                @if(isset($campo['min'])) min="{{ $campo['min'] }}" @endif
                                                @if(isset($campo['max'])) max="{{ $campo['max'] }}" @endif
                                                required
                                            />
                                            @error($campo['name'])
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>

                                <!-- DERECHA: Campos calculados solo lectura -->
                                <div class="col-md-6 border-start ps-4">
                                    <h5 class="text-primary fw-bold mb-4">
                                        <i class="bi bi-graph-up-arrow me-2"></i>Valoración y Riesgo Calculados
                                    </h5>

                                    <div class="mb-3">
                                        <label for="va" class="form-label fw-semibold d-flex align-items-center gap-2">
                                            <i class="bi bi-calculator text-info fs-5"></i> VA (Valoración Activo)
                                        </label>
                                        <input type="number" id="va" name="va" class="form-control calculated-value" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="va_interpretacion" class="form-label fw-semibold d-flex align-items-center gap-2">
                                            <i class="bi bi-info-circle text-info fs-5"></i> Interpretación VA
                                        </label>
                                        <input type="text" id="va_interpretacion" name="va_interpretacion" class="form-control calculated-value" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="va_accion" class="form-label fw-semibold d-flex align-items-center gap-2">
                                            <i class="bi bi-clipboard-check text-info fs-5"></i> Acción VA
                                        </label>
                                        <input type="text" id="va_accion" name="va_accion" class="form-control calculated-value" readonly>
                                    </div>

                                    <hr class="my-4">

                                    <div class="mb-3">
                                        <label for="riesgo" class="form-label fw-semibold d-flex align-items-center gap-2">
                                            <i class="bi bi-exclamation-octagon-fill text-danger fs-5"></i> Riesgo
                                        </label>
                                        <input type="number" id="riesgo" name="riesgo" class="form-control calculated-value" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nivel_riesgo" class="form-label fw-semibold d-flex align-items-center gap-2">
                                            <i class="bi bi-speedometer2 text-danger fs-5"></i> Nivel de Riesgo
                                        </label>
                                        <input type="text" id="nivel_riesgo" name="nivel_riesgo" class="form-control calculated-value" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tratamiento" class="form-label fw-semibold d-flex align-items-center gap-2">
                                            <i class="bi bi-tools text-danger fs-5"></i> Tratamiento
                                        </label>
                                        <textarea id="tratamiento" name="tratamiento" rows="3" class="form-control calculated-value" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button id="submitBtn" type="submit" class="btn btn-success btn-lg d-flex align-items-center gap-2">
                                    <i class="bi bi-save2"></i> Guardar Activo
                                    <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tu JS personalizado -->
    <script src="{{ asset('js/activo-create.js') }}"></script>
</body>
</html>