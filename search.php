<?php
// search.php - AJAX Search Handler
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    exit('Unauthorized');
}

$title = $_GET['title'] ?? '';
$genre = $_GET['genre'] ?? '';
$year = $_GET['year'] ?? '';

$query = "SELECT * FROM songs WHERE user_id = ?";
$params = [$_SESSION['user_id']];

if ($title) {
    $query .= " AND title LIKE ?";
    $params[] = "%$title%";
}
if ($genre) {
    $query .= " AND genre LIKE ?";
    $params[] = "%$genre%";
}
if ($year) {
    $query .= " AND release_year = ?";
    $params[] = $year;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$songs = $stmt->fetchAll();

foreach ($songs as $song) {
    echo "<tr>";
    echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($song['title']) . "</td>";
    echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($song['artist']) . "</td>";
    echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($song['genre']) . "</td>";
    echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($song['release_year']) . "</td>";
    echo "<td class='px-6 py-4 whitespace-nowrap'><span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800'>" . htmlspecialchars($song['popularity_score']) . "/10</span></td>";
    echo "<td class='px-6 py-4 whitespace-nowrap text-right text-sm font-medium'>";
    echo "<a href='edit_song.php?id=" . $song['id'] . "' class='text-indigo-600 hover:text-indigo-900 mr-3'>Edit</a>";
    echo "<a href='delete_song.php?id=" . $song['id'] . "' class='text-red-600 hover:text-red-900' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
    echo "</td>";
    echo "</tr>";
}

if (empty($songs)) {
    echo "<tr><td colspan='6' class='px-6 py-4 text-center text-gray-500'>No results found.</td></tr>";
}
?>
