<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: loginpage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIS</title>
    <link rel="stylesheet" href="uis.css">
    <link rel="icon" type="image/x-icon" href="favicon.png">
</head>
<body>
    <header>
        <h3>UIS User Dashboard</h3>
    </header>
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
                <div>Email   : <span class="special"><?php echo $user['phone']; ?></span></div>
            </div>
        </div>
        <h3>Click here to <a href="logout.php">log-out</a></h3><hr>
        <div class="summary">
            <h2>UIS(User Identification System)</h2>
            <p>We are excited to present the User Identification System (UIS), a project developed by a team of dedicated
                 students from the Cyber Security Department as part of our Database Management Systems (DBMS) coursework.</p>
            <h3>Overview</h3>
            <p>The UIS is designed to efficiently identify users and direct them to the appropriate 
                dashboard based on their administrative privileges.</p>
            <h3>User Dashboard</h3>
            <p>Upon logging in, users are greeted with the User Dashboard, which displays their personal details. We have 
                also included functionality that allows users to edit their information, ensuring that they can keep their
                 profiles up to date.</p>
            <h3>Admin Dashboard</h3>
            <p>For administrators, the Admin Dashboard offers a comprehensive view of all users in the system, in addition 
                to their own details. Administrators have the ability to edit any user's information and can promote users 
                to administrative status when necessary. </p>
            <h3>Conclusion</h3>
            <p>We believe that the UIS will serve as a valuable tool for managing user identities and privileges within our
                 application. We look forward to receiving feedback and continuing to improve this system.</p>
        </div>
    </div>

    <footer>
        <p style="text-align: center;">Connect with us for updates, support, and more!<br><a href="mailto:joeljoju.cy23@jecc.ac.in" title="click to send mail">Contact us</a></p>
    </footer>
</body>
</html>