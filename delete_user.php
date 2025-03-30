<?php
session_start();
require 'config.php';

// Restrict access to admins only
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header("Location: loginpage.php");
    exit();
}


// Get user ID from URL and validate
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($user_id > 0) {
    try {
        // Delete user from database
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
    } catch(PDOException $e) {
        // Log errors (optional)
        error_log("Delete failed: " . $e->getMessage());
    }
}

// Redirect back to admin dashboard
header("Location: admin.php");
exit();
?>