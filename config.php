<?php
// config.php - Database configuration and Twig initialization
require_once __DIR__ . '/vendor/autoload.php';

session_start();

// Database credentials
$host = 'localhost';
$db   = 'musicapp';
$user = 'root';
$pass = 'root';
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
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Twig Setup
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // Set to __DIR__ . '/compilation_cache' in production
    'autoescape' => 'html',
]);

// Global variables for templates
$twig->addGlobal('session', $_SESSION);

// Helper for CAPTCHA
function generateCaptcha() {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $_SESSION['captcha_result'] = $num1 + $num2;
    return "$num1 + $num2 = ?";
}
?>
