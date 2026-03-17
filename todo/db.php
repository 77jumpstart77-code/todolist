<?php
$host = 'localhost';
$db   = 'todo_db';
$user = 'root';
$pass = 'Y3wPQs9V@6Cl';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // If database doesn't exist, we might need to handle it or instruct the user to run init.sql
     die("Database connection failed: " . $e->getMessage());
}
?>
