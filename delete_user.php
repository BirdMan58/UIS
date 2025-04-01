<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header("Location: loginpage.php");
    exit();
}


$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($user_id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
    } catch(PDOException $e) {
        error_log("Delete failed: " . $e->getMessage());
    }
}

header("Location: admin.php");
exit();
?>