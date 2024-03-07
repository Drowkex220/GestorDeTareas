<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura mensual de {{ $data['nombre'] }}</title>
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
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
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
        <p>Cliente: {{ $data['nombre'] }}</p>
        <p>CIF: {{ $data['cif'] }}</p>
        <p>Fecha de Emisión: {{ $fecha_emision }}</p>
    </header>

    <section>
        <h2>Detalles de la Factura</h2>
        @if (!isset($cuota))
        <p><strong>Concepto:</strong> Factura mensual</p>
        <p><strong>Notas:</strong> Factura mensual generada automaticamente</p>
        @endif
        @if (isset($cuota))
            <p><strong>Concepto:</strong> {{ $cuota['concepto'] }}</p>
            <p><strong>Notas:</strong> {{ $cuota['notas'] }}</p>

        @endif

        <p><strong>Importe Mensual:</strong> {{ $data['importe_c_mensual'] }} {{ $moneda }}</p>

    </section>

    <footer>
        <p>Factura generada automáticamente por el sistema.</p>
    </footer>

</body>
</html>
