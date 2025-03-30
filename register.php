<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check password match
    if($_POST['passwd'] !== $_POST['repasswd']) {
        header("Location: signin.php?error=password_mismatch");
        exit();
    }

    // Check if username exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$_POST['uname']]);
    if($stmt->rowCount() > 0) {
        header("Location: signin.php?error=username_exists");
        exit();
    }

    // Proceed with registration
    $data = [
        'fname' => htmlspecialchars($_POST['fname']),
        'lname' => htmlspecialchars($_POST['lname']),
        'dob' => $_POST['dob'],
        'phno' => htmlspecialchars($_POST['phno']),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
        'uname' => htmlspecialchars($_POST['uname']),
        'passwd' => password_hash($_POST['passwd'], PASSWORD_DEFAULT),
        'admin' => isset($_POST['admin']) ? 1 : 0 
    ];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, dob, phone, email, username, password, admin) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
        $data['fname'], $data['lname'], $data['dob'], $data['phno'], 
        $data['email'], $data['uname'], $data['passwd'], $data['admin']
]);
        header("Location: loginpage.php?success=registered");
    } catch(PDOException $e) {
        header("Location: signin.php?error=registration_error");
    }
    exit();
}
?>