<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Evaluación de Riesgo Cibernético</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .container { max-width: 1200px; margin: auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background-color: #0056b3; }
        .success { color: green; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Evaluación de Riesgo Cibernético</h2>
        <a href="{{ route('activos.create') }}" class="btn">Nuevo Activo</a>
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Activo</th>
                    <th>Tipo</th>
                    <th>Propietario</th>
                    <th>Ubicación</th>
                    <th>VA</th>
                    <th>Amenaza</th>
                    <th>Riesgo</th>
                    <th>Nivel</th>
                    <th>Tratamiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activos as $activo)
                    <tr>
                        <td>{{ $activo->id }}</td>
                        <td>{{ $activo->nombre_activo }}</td>
                        <td>{{ $activo->tipo_activo }}</td>
                        <td>{{ $activo->propietario }}</td>
                        <td>{{ $activo->ubicacion }}</td>
                        <td>{{ $activo->va }}</td>
                        <td>{{ $activo->amenaza }}</td>
                        <td>{{ $activo->riesgo }}</td>
                        <td>{{ $activo->nivel_riesgo }}</td>
                        <td>{{ $activo->tratamiento }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>