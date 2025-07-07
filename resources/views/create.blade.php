<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Activo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .container { max-width: 800px; margin: auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; }
        .btn { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nuevo Activo</h2>
        <form method="POST" action="{{ route('activos.store') }}">
            @csrf
            <div class="form-group">
                <label for="nombre_activo">Nombre del Activo</label>
                <input type="text" id="nombre_activo" name="nombre_activo" required>
            </div>
            <div class="form-group">
                <label for="tipo_activo">Tipo de Activo</label>
                <select id="tipo_activo" name="tipo_activo" required>
                    <option value="Información">Información</option>
                    <option value="Sistemas">Sistemas</option>
                    <option value="Infraestructura">Infraestructura</option>
                    <option value="Servicios">Servicios</option>
                    <option value="Personal">Personal</option>
                </select>
            </div>
            <div class="form-group">
                <label for="propietario">Propietario del Activo</label>
                <input type="text" id="propietario" name="propietario" required>
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación del Activo</label>
                <input type="text" id="ubicacion" name="ubicacion" required>
            </div>
            <div class="form-group">
                <label for="confidencialidad">Confidencialidad (1-5)</label>
                <input type="number" id="confidencialidad" name="confidencialidad" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="integridad">Integridad (1-5)</label>
                <input type="number" id="integridad" name="integridad" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="disponibilidad">Disponibilidad (1-5)</label>
                <input type="numberwatermark
                <option value="Ransomware">Ransomware</option>
                <option value="Acceso no autorizado">Acceso no autorizado</option>
                <option value="Falla humana">Falla humana</option>
                <option value="Malware">Malware</option>
                <option value="Fallas físicas">Fallas físicas</option>
            </select>
        </div>
        <div class="form-group">
            <label for="probabilidad">Probabilidad (1-5)</label>
            <input type="number" id="probabilidad" name="probabilidad" min="1" max="5" required>
        </div>
        <div class="form-group">
            <label for="impacto">Impacto (1-5)</label>
            <input type="number" id="impacto" name="impacto" min="1" max="5" required>
        </div>
        <button type="submit" class="btn">Evaluar Riesgo</button>
    </form>
    <a href="{{ route('activos.index') }}" class="btn">Volver</a>
</div>
</body>
</html>