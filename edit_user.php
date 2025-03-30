<?php
session_start();
require 'config.php';

// Restrict to admins only
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header("Location: loginpage.php");
    exit();
}

// Get user ID from URL
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: admin.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_status = isset($_POST['admin']) ? 1 : 0;
    
    $stmt = $pdo->prepare("UPDATE users SET 
        first_name = ?,
        last_name = ?,
        email = ?,
        admin = ?
        WHERE id = ?");

    $stmt->execute([
        htmlspecialchars($_POST['fname']),
        htmlspecialchars($_POST['lname']),
        filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
        $admin_status,
        $user_id
    ]);

    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="uis.css">
</head>
<body>
    <header>
        <h3>Edit User</h3>
        <a style="color:white;" href="admin.php">← Back to Dashboard</a>
    </header>

    <form method="POST">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="fname" 
                   value="<?= htmlspecialchars($user['first_name']) ?>" required>
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lname" 
                   value="<?= htmlspecialchars($user['last_name']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" 
                   value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>Admin Status:</label>
            <input type="checkbox" name="admin" 
                <?= $user['admin'] ? 'checked' : '' ?>>
        </div>

        <p style="text-align: left;" >Please note: An administrator has the authority to view and modify the details of all users, as well as to add or remove both administrators and users.</p>

        <div class="butcon">
        <button type="submit">Save Changes</button>
        <button onclick="location.href='admin.php'" class="button">Cancel</button>
        </div>
    </form>
</body>
</html>