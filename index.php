<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Render + PHP + Supabase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .counter {
            font-size: 5rem;
            text-align: center;
            margin: 40px 0;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            font-weight: bold;
        }
        .info {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .success {
            color: #4ade80;
            font-weight: bold;
        }
        .label {
            opacity: 0.8;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🚀 Render + PHP + Supabase</h1>";
        
// Conectar a la base de datos
$contador = 0;
$db_status = '';

try {
    $db_url = getenv('DATABASE_URL');
    
    if (!$db_url) {
        throw new Exception('DATABASE_URL no configurada');
    }
    
    $db_parts = parse_url($db_url);
    $host = $db_parts['host'];
    $port = $db_parts['port'] ?? 5432;
    $dbname = ltrim($db_parts['path'], '/');
    $user = $db_parts['user'];
    $pass = $db_parts['pass'];
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $conn = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    
    // Incrementar contador
    $conn->exec("UPDATE visitantes SET contador = contador + 1 WHERE id = 1");
    
    // Obtener contador
    $stmt = $conn->query("SELECT contador FROM visitantes WHERE id = 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $contador = $result ? $result['contador'] : 0;
    
    $db_status = "<span class='success'>✅ Conectado a Supabase</span>";
    
} catch (Exception $e) {
    $db_status = "❌ Error: " . htmlspecialchars($e->getMessage());
}

echo "<div class='counter'>$contador</div>";
echo "<p style='text-align: center; font-size: 1.2rem; opacity: 0.9;'>visitas totales</p>";

echo "<div class='info'>";
echo "<p class='label'>Estado de la base de datos:</p>";
echo "<p>$db_status</p>";
echo "</div>";

echo "<div class='info'>";
echo "<p class='label'>Información del sistema:</p>";
echo "<p><strong>PHP:</strong> " . phpversion() . "</p>";
echo "<p><strong>Servidor:</strong> Apache</p>";
echo "<p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "</div>";

echo "<div style='text-align: center; margin-top: 30px; opacity: 0.7;'>";
echo "<p>🔗 GitHub → Render → Supabase</p>";
echo "</div>";

echo "</div>
</body>
</html>";
?>