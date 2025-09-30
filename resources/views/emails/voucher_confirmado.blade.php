<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Compra</title>
</head>
<body>
    <h2>¡Hola {{ $venta->cliente->nombre }}!</h2>
    <p>Tu compra con Botica Mirian ha sido confirmada. 🎉</p>
    <p><strong>Total:</strong> S/ {{ number_format($venta->total, 2) }}</p>
    <p>Adjuntamos tu voucher validado.</p>
    <p>Gracias por tu compra 💜</p>
</body>
</html>
