<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:20px; }
        .container { max-width:500px; margin:auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.1); }
        .header { background:#16a34a; color:white; padding:30px; text-align:center; }
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
            <h1>🎉 ¡Venta confirmada!</h1>
            <p style="margin:5px 0 0">Tu producto ha sido vendido</p>
        </div>
        <div class="body">
            <p>Hola <strong>{{ $venta->vendedor->nombre }}</strong>,</p>
            <p>Te informamos que tu venta ha sido validada por nuestro equipo. Aquí están los detalles:</p>

            <div style="background:#f9f9f9;border-radius:8px;padding:15px;margin:20px 0">
                <div class="dato">
                    <span>Producto vendido</span>
                    <span>{{ $venta->producto->nombre }}</span>
                </div>
                <div class="dato">
                    <span>Comprador</span>
                    <span>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</span>
                </div>
                <div class="dato">
                    <span>Correo del comprador</span>
                    <span>{{ $venta->cliente->correo }}</span>
                </div>
                <div class="dato">
                    <span>Fecha de venta</span>
                    <span>{{ $venta->fecha }}</span>
                </div>
                <div class="dato">
                    <span>Total recibido</span>
                    <span style="color:#16a34a;font-size:18px">${{ number_format($venta->total, 2) }}</span>
                </div>
            </div>

            <p style="color:#666;font-size:14px">
                El comprador puede contactarte si tiene alguna duda sobre el producto.
            </p>
        </div>
        <div class="footer">
            E-Commerce &copy; {{ date('Y') }} — No respondas este correo.
        </div>
    </div>
</body>
</html>
