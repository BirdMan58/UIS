<?php
session_start();
require 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginpage.php");
    exit();
}

$error = '';
$success = '';

// Get current user's data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        header("Location: logout.php");
        exit();
    }
} catch(PDOException $e) {
    die("Error fetching user data: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitize inputs
        $fname = htmlspecialchars($_POST['fname']);
        $lname = htmlspecialchars($_POST['lname']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phno = htmlspecialchars($_POST['phno']);
        
        // Password update logic
        $password_update = '';
        $params = [
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'phno' => $phno,
            'id' => $_SESSION['user_id']
        ];

        if (!empty($_POST['new_password'])) {
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                throw new Exception("Passwords do not match!");
            }
            $password_update = ', password = :password';
            $params['password'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        }

        // Build and execute query
        $sql = "UPDATE users SET 
                first_name = :fname, 
                last_name = :lname, 
                email = :email, 
                phone = :phno 
                $password_update 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // Update session with new first name
        $_SESSION['first_name'] = $fname;
        
        $success = "Profile updated successfully!";
        
    } catch(PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="uis.css">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <h3>Edit Your Profile</h3>
        <a style="color:white;" href="uis.php">← Back to Dashboard</a>
    </header>

    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="fname" required 
                   value="<?php echo htmlspecialchars($user['first_name']); ?>">
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lname" required 
                   value="<?php echo htmlspecialchars($user['last_name']); ?>">
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required 
                   value="<?php echo htmlspecialchars($user['email']); ?>">
        </div>

        <div class="form-group">
            <label>Phone Number:</label>
            <input type="text" name="phno" required 
                   value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>

        <div class="form-group">
            <label>New Password (leave blank to keep current):</label>
            <input type="password" name="new_password">
        </div>

        <div class="form-group">
            <label>Confirm New Password:</label>
            <input type="password" name="confirm_password">
        </div>

        <div class="butcon">
            <button type="submit">Save Changes</button>
            <button onclick="location.href='uis.php'" class="button">Cancel</button>
        </div>
    </form>
    <footer>
        <p style="text-align: center;">Connect with us for updates, support, and more!<br><a href="mailto:joeljoju.cy23@jecc.ac.in" title="click to send mail">Contact us</a></p>
    </footer>
</body>
</html>