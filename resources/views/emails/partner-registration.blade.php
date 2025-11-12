<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Socio - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #3BB77E;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 12px;
            color: #666;
        }
        .info-row {
            display: flex;
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border-left: 4px solid #3BB77E;
        }
        .label {
            font-weight: bold;
            color: #3BB77E;
            min-width: 140px;
        }
        .value {
            flex: 1;
            color: #333;
        }
        .highlight {
            background-color: #e8f5e8;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #3BB77E;
        }
        .type-badge {
            display: inline-block;
            padding: 5px 15px;
            background-color: #3BB77E;
            color: white;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <h2>Nueva Solicitud de Socio</h2>
    </div>

    <div class="content">
        <div class="highlight">
            <h3 style="margin: 0 0 10px 0; color: #3BB77E;">
                <span class="type-badge">{{ ucfirst($tipo_socio) }}</span>
            </h3>
            <p style="margin: 0; color: #666;">
                Se ha registrado una nueva solicitud para unirse como {{ $tipo_socio }} en {{ config('app.name') }}.
            </p>
        </div>

        <h3 style="color: #3BB77E; margin-bottom: 20px;">Información del Solicitante:</h3>

        <div class="info-row">
            <div class="label">Nombre Completo:</div>
            <div class="value">{{ $nombre_completo }}</div>
        </div>

        <div class="info-row">
            <div class="label">Email:</div>
            <div class="value">
                <a href="mailto:{{ $email }}" style="color: #3BB77E; text-decoration: none;">{{ $email }}</a>
            </div>
        </div>

        <div class="info-row">
            <div class="label">WhatsApp:</div>
            <div class="value">
                <a href="https://wa.me/51{{ $whatsapp }}" style="color: #3BB77E; text-decoration: none;">
                    +51 {{ $whatsapp }}
                </a>
            </div>
        </div>

        <div class="info-row">
            <div class="label">Tipo de Socio:</div>
            <div class="value">
                <strong style="color: #3BB77E;">{{ ucfirst($tipo_socio) }}</strong>
            </div>
        </div>

        <div class="info-row">
            <div class="label">Fecha de Solicitud:</div>
            <div class="value">{{ date('d/m/Y H:i:s') }}</div>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #e8f4fd; border-radius: 8px; border-left: 4px solid #2196F3;">
            <h4 style="margin: 0 0 10px 0; color: #1976D2;">Acciones Recomendadas:</h4>
            <ul style="margin: 10px 0; padding-left: 20px; color: #666;">
                <li>Contactar al solicitante vía WhatsApp o email</li>
                <li>Verificar la información proporcionada</li>
                <li>Enviar información adicional sobre el proceso</li>
                <li>Programar una reunión si es necesario</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>Este email fue generado automáticamente desde el sitio web de {{ config('app.name') }}.<br>
        Fecha: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>