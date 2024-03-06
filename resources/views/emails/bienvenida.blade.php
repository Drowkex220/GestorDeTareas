<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura mensual de laravel</title>
</head>
<body>
    <h1>Factura para {{ $datos['nombre'] }}</h1>
    <p>Pais: {{ $datos->pais }}</p>
    <p>Los datos de la factura se encuentran en el archivo pdf adjunto</p>
    <p>Esperamos que disfrutes de tu experiencia con nosotros.</p>
    <p>Saludos,</p>
    <p>Tu equipo</p>
</body>
</html>
