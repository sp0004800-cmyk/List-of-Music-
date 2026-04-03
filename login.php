<?php
// login.php
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $captcha = isset($_POST['captcha']) ? (int)$_POST['captcha'] : 0;

    if ($captcha !== (int)$_SESSION['captcha_result']) {
        $error = 'Invalid CAPTCHA answer.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

$captcha_question = generateCaptcha();
echo $twig->render('login.twig', ['error' => $error, 'captcha' => $captcha_question]);
?>
