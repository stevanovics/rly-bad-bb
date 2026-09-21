<?php

header('Content-Type: application/json');

$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('DB_NAME') ?: 'app_db';
$user = getenv('DB_USER') ?: 'app_user';
$pass = getenv('DB_PASSWORD') ?: 'secret';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $dbStatus = 'Connected successfully!';
} catch (PDOException $e) {
    $dbStatus = 'Connection failed: ' . $e->getMessage();
}

echo json_encode([
    'message' => 'Hello from PHP-FPM!',
    'uri' => $_SERVER['REQUEST_URI'],
    'database_status' => $dbStatus
], JSON_PRETTY_PRINT);
