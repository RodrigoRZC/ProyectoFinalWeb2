<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:20px; }
        .container { max-width:500px; margin:auto; background:white; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.1); }
        .header { background:#4f46e5; color:white; padding:30px; text-align:center; }
        .header h1 { margin:0; font-size:24px; }
        .body { padding:30px; text-align:center; }
        .codigo { font-size:48px; font-weight:bold; color:#4f46e5; letter-spacing:12px; margin:20px 0; padding:20px; background:#f0f0ff; border-radius:8px; }
        .footer { background:#f9f9f9; padding:15px; text-align:center; font-size:12px; color:#999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 E-Commerce</h1>
            <p style="margin:5px 0 0">Verificación de acceso</p>
        </div>
        <div class="body">
            <p>Hola <strong>{{ $usuario->nombre }}</strong>,</p>
            <p>Tu código de verificación es:</p>
            <div class="codigo">{{ $codigo }}</div>
            <p style="color:#666;font-size:14px">
                Este código expira en <strong>5 minutos</strong>.<br>
                Si no solicitaste este código, ignora este correo.
            </p>
        </div>
        <div class="footer">
            E-Commerce &copy; {{ date('Y') }} — No respondas este correo.
        </div>
    </div>
</body>
</html>
