<?php
// add_song.php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $year = $_POST['release_year'];
    $duration = $_POST['duration'];
    $popularity = $_POST['popularity_score'];

    $stmt = $pdo->prepare("INSERT INTO songs (title, artist, genre, release_year, duration, popularity_score, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $artist, $genre, $year, $duration, $popularity, $_SESSION['user_id']]);
    
    header('Location: index.php');
    exit;
}

echo $twig->render('add_song.twig');
?>
