<?php
// register.php
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $captcha = isset($_POST['captcha']) ? (int)$_POST['captcha'] : 0;

    if ($captcha !== (int)$_SESSION['captcha_result']) {
        $error = 'Invalid CAPTCHA answer.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashed_password]);
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Username already exists.';
        }
    }
}

$captcha_question = generateCaptcha();
echo $twig->render('register.twig', ['error' => $error, 'captcha' => $captcha_question]);
?>
