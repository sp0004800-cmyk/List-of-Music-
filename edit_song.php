<?php
// edit_song.php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM songs WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$song = $stmt->fetch();

if (!$song) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $year = $_POST['release_year'];
    $duration = $_POST['duration'];
    $popularity = $_POST['popularity_score'];

    $stmt = $pdo->prepare("UPDATE songs SET title = ?, artist = ?, genre = ?, release_year = ?, duration = ?, popularity_score = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $artist, $genre, $year, $duration, $popularity, $id, $_SESSION['user_id']]);
    
    header('Location: index.php');
    exit;
}

echo $twig->render('edit_song.twig', ['song' => $song]);
?>
