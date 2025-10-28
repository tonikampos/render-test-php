<?php
/**
 * Generador de hash bcrypt para contraseñas
 * Usa el mismo algoritmo que la aplicación (bcrypt cost 12)
 */

$password = 'Pass123456';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

echo "===========================================\n";
echo "GENERADOR DE HASH BCRYPT\n";
echo "===========================================\n\n";
echo "Contraseña: {$password}\n";
echo "Hash generado (cost 12):\n\n";
echo $hash . "\n\n";
echo "===========================================\n";
echo "Copia este hash y reemplázalo en el archivo:\n";
echo "database/reset_supabase.sql\n";
echo "===========================================\n";
