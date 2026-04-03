<?php
// index.php - Main Controller
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM songs WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$songs = $stmt->fetchAll();

echo $twig->render('index.twig', ['songs' => $songs]);
?>
