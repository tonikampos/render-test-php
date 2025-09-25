<?php
// --- 1. CONEXIÓN A LA BASE DE DATOS DE RENDER ---
$db_url = getenv('DATABASE_URL');
$conn = null;
$error_msg = '';

if ($db_url === false) {
    $error_msg = "Error: No se encontró la variable de entorno DATABASE_URL.";
} else {
    try {
        $db_parts = parse_url($db_url);

        $host = $db_parts['host'];
        // --- LÍNEA CORREGIDA ---
        // Si la URL no especifica el puerto, usamos el 5432 por defecto para PostgreSQL
        $port = $db_parts['port'] ?? '5432';
        // --- FIN DE LA CORRECCIÓN ---
        $dbname = ltrim($db_parts['path'], '/');
        $user = $db_parts['user'];
        $password = $db_parts['pass'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
        $conn = new PDO($dsn);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        $error_msg = "Error de conexión a la base de datos: " . $e->getMessage();
        $conn = null;
    }
}

// --- 2. LÓGICA DEL CONTADOR DE VISITAS ---
$contador = 0;
if ($conn) {
    try {
        $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");
        $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $contador = $resultado ? $resultado['contador'] : 0;
    } catch (PDOException $e) {
        $error_msg = "Error en la consulta: " . $e->getMessage() . "<br>Asegúrate de haber creado la tabla 'visitantes' en la base de datos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Despliegue en Render</title>
    <style>
        body { font-family: sans-serif; display: grid; place-content: center; height: 100vh; margin: 0; background: #f0f2f5; text-align: center; }
        .container { background: white; padding: 2rem 4rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { color: #1877f2; }
        p { font-size: 2.5rem; font-weight: bold; color: #333; margin: 1rem 0; }
        .error { color: #d93025; font-weight: bold; max-width: 600px; font-size: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 ¡Hola desde Render! 🚀</h1>
        <p>Esta página ha sido visitada:</p>
        <p><?php echo htmlspecialchars($contador); ?> veces</p>

        <?php if ($error_msg): ?>
            <p class="error"><?php echo $error_msg; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>