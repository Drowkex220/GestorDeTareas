<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Laravel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
        }
        header p {
            margin: 5px 0;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <header>
        <h1>Factura Mensual</h1>
        <p>Cliente: {{ $datos['nombre'] }}</p>
        <p>País: {{ $datos['pais'] }}</p>
    </header>

    <section>
        <h2>Detalles de la Factura</h2>
        <p>Los datos de la factura se encuentran en el archivo PDF adjunto.</p>
        <p>Esperamos que disfrutes de tu experiencia con nosotros.</p>
        <p>Saludos,</p>
        <p>Tu equipo</p>
    </section>

    <footer>
        <p>Este correo electrónico se ha generado automáticamente. Por favor, no responda a esta dirección de correo.</p>
    </footer>

</body>
</html>
