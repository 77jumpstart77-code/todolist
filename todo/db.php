<?php
// Secure Environment Configuration
// Use environment variables or a separate config file for production

$host = 'localhost';
$db   = 'todo_db';
$user = 'root';
$pass = 'Y3wPQs9V@6Cl'; // WARNING: Hardcoded password. Should be in Env variable.
$charset = 'utf8mb4';

function get_pdo_connection() {
    global $host, $db, $user, $pass, $charset;
    
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // Critical for SQL Injection prevention
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // Log error instead of displaying it to users
        error_log($e->getMessage());
        die("Connection Database Error.");
    }
}

$pdo = get_pdo_connection();
?>
