<?php
// --- 1. CONEXIÓN A LA BASE DE DATOS DE RENDER ---
// Render nos da la URL de conexión en una "Variable de Entorno".
// Esta es la forma segura y profesional de manejar contraseñas.
$db_url = getenv('DATABASE_URL');
$conn = null;
$error_msg = '';

if ($db_url === false) {
    $error_msg = "Error: No se encontró la variable de entorno DATABASE_URL.";
} else {
    try {
        // La URL de Render es tipo 'postgres://user:password@host:port/dbname'
        // PDO necesita los datos por separado, así que la "parseamos"
        $db_parts = parse_url($db_url);

        $host = $db_parts['host'];
        $port = $db_parts['port'];
        $dbname = ltrim($db_parts['path'], '/');
        $user = $db_parts['user'];
        $password = $db_parts['pass'];

        // Creamos la conexión con PDO (la forma moderna de conectar a BBDD en PHP)
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
    // Si la conexión fue exitosa, actualizamos y obtenemos el contador
    try {
        // Incrementamos el contador en 1
        $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");

        // Obtenemos el nuevo valor
        $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $contador = $resultado ? $resultado['contador'] : 0;
    } catch (PDOException $e) {
        // Esto pasará si la tabla 'visitantes' aún no existe.
        $error_msg = "Error en la consulta: " . $e->getMessage() . "<br>Asegúrate de haber creado la tabla 'visitantes' en la base de datos (Paso 4).";
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
        .error { color: #d93025; font-weight: bold; }
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