<?php
session_start(); // Critical: Start the session
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['uname'];
    $password = $_POST['passwd'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['admin'] = (bool)$user['admin']; // Fix: Cast to boolean

        if ($_SESSION['admin']) {
            header("Location: admin.php");
        } else {
            header("Location: uis.php");
        }
        exit();
    } else {
        header("Location: loginpage.php?error=1");
        exit();
    }
}
?>