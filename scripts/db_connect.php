<?php
/**
 * db_connect.php
 * Archivo para manejar la conexión a la base de datos (PostgreSQL)
 */

// ** ⚠️ CONFIGURACIÓN DE LA BASE DE DATOS ⚠️ **
// ¡Asegúrate de cambiar estos valores por los tuyos!
$host = 'localhost';     // O la IP de tu servidor PostgreSQL
$db   = 'local'; // <-- CAMBIA ESTO
$user = 'db'; // <-- CAMBIA ESTO
$pass = 'db'; // <-- CAMBIA ESTO
$port = '0000';          // Puerto estándar de PostgreSQL, cámbialo si es diferente

// La cadena DSN para PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";

$options = [
    // Activa el manejo de errores y excepciones
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // Puedes agregar más opciones de conexión específicas de PGSQL si las necesitas
];

try {
    // Intentamos establecer la conexión usando PDO
    $pdo = new PDO($dsn);

    // Opcional: Asegurarnos que la codificación sea UTF8
    $pdo->exec("SET client_encoding TO 'UTF8'");

} catch (\PDOException $e) {
    // Si la conexión falla, mostramos un error
    // En producción, solo deberías decir: "Error de servidor, inténtalo más tarde."
    die("❌ ¡Conexión fallida a PostgreSQL! Por favor, verifica tu 'db_connect.php'." .
        " Error: " . $e->getMessage());
}

// ¡La variable $pdo ahora contiene nuestra conexión PDO funcional!
?>