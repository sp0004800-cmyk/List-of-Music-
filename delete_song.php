<?php
// delete_song.php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM songs WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

header('Location: index.php');
exit;
?>
