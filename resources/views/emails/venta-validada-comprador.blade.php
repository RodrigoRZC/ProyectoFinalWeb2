<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:20px; }
        .container { max-width:500px; margin:auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.1); }
        .header { background:#4f46e5; color:white; padding:30px; text-align:center; }
        .body { padding:30px; }
        .dato { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f0f0f0; }
        .dato span:first-child { color:#666; font-size:14px; }
        .dato span:last-child { font-weight:bold; color:#333; }
        .footer { background:#f9f9f9; padding:15px; text-align:center; font-size:12px; color:#999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ ¡Compra validada!</h1>
            <p style="margin:5px 0 0">Tu pago ha sido confirmado</p>
        </div>
        <div class="body">
            <p>Hola <strong>{{ $venta->cliente->nombre }}</strong>,</p>
            <p>¡Tu compra ha sido validada! Aquí están los detalles:</p>

            <div style="background:#f9f9f9;border-radius:8px;padding:15px;margin:20px 0">
                <div class="dato">
                    <span>Producto</span>
                    <span>{{ $venta->producto->nombre }}</span>
                </div>
                <div class="dato">
                    <span>Fecha</span>
                    <span>{{ $venta->fecha }}</span>
                </div>
                <div class="dato">
                    <span>Total pagado</span>
                    <span style="color:#4f46e5;font-size:18px">${{ number_format($venta->total, 2) }}</span>
                </div>
            </div>

            <div style="background:#ede9fe;border-radius:8px;padding:15px;margin:20px 0">
                <p style="margin:0 0 8px;font-weight:bold;color:#4f46e5">📬 Datos del vendedor</p>
                <p style="margin:0;font-size:14px;color:#333">
                    <strong>{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</strong><br>
                    Para coordinar la entrega de tu producto, contacta al vendedor en:<br>
                    <a href="mailto:{{ $venta->vendedor->correo }}"
                       style="color:#4f46e5">{{ $venta->vendedor->correo }}</a>
                </p>
            </div>

            <p style="color:#666;font-size:14px">
                Gracias por tu compra. Si tienes algún problema, contáctanos.
            </p>
        </div>
        <div class="footer">
            E-Commerce &copy; {{ date('Y') }} — No respondas este correo.
        </div>
    </div>
</body>
</html>
