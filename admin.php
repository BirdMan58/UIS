<?php
session_start();
// Restrict access to admins only
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] !== true) {
    header("Location: loginpage.php");
    exit();
}
require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="uis.css">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header><h3>Admin Dashboard</h3></header>
    <div class="maincon">
        <h1>Welcome <span style="color:#04aa6d;"> <?php echo htmlspecialchars($_SESSION['first_name']); ?> </span>!</h1>
        <h3>Profile <a href="edit_profile.php">🖉 </a></h3>
        <div class="flex">
            <div class="imgcon">
                <img src="dp.jpg" alt="Profile Picture" style="float: left;width: 200px;height: 200px;border-radius: 50%;">
            </div>
            <div class="det">
                <?php
                    require 'config.php';
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    $user = $stmt->fetch();
                ?>
                <div><h2><?php echo $user['first_name']; ?><span style="color:rgba(0, 0, 0, 0);">_</span><?php echo $user['last_name']; ?></h2></div>
                <div>Username: <span class="special"><?php echo $user['username']; ?></span></div>
                <div>BirthDay: <span class="special"><?php echo $user['dob']; ?></span></div>
                <div>Phone: <span class="special"><?php echo $user['phone']; ?></span></div>
                <div>Email   : <span class="special"><?php echo $user['email']; ?></span></div>
            </div>
        </div>
        <h3>Click here to <a href="logout.php">log-out</a></h3>
    

    <!-- Display All Users -->
    <h2>User List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Admin</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM users");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['username']}</td>
                <td>" . ($row['admin'] ? 'Yes' : 'No') . "</td>
                <td> <a href='edit_user.php?id={$row['id']}'>Edit 🖉</a></td>
                <td>  <a href='delete_user.php?id={$row['id']}' onclick='return confirm(\"Deleting this user will be permanent and cannot be undone. Are you sure you want to proceed?\");'>Delete 🗑</a></td>
            </tr>";
        }
        ?>
    </table>
    <footer>
        <p style="text-align: center;">Connect with us for updates, support, and more!<br><a href="mailto:joeljoju.cy23@jecc.ac.in" title="click to send mail">Contact us</a></p>
    </footer>
    </body>
</html>