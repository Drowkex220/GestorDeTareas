<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura mensual de {{ $data['nombre'] }}</title>
</head>
<body>

    <h1>Factura mensual de Laravel</h1>
    <p>Su inporte ha sido convertido a {{$moneda}}</p>
    <p><strong>Importe: </strong> {{ $data['importe_c_mensual'] * $conversion }}</p>

</body>
<footer>
    <p>Footer de factura</p>
</footer>
</html>
