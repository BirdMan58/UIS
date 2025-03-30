<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: uis.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign-in page</title>
        <link rel="stylesheet" href="uis.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header><h3>UIS Sign-in</h3></header>
        
        <?php if(isset($_GET['error'])): ?>
            <p class="error" style="color:rgb(255, 255, 255); text-align:left; display: block;">
                <?php 
                if($_GET['error'] == 'password_mismatch') {
                    echo 'Passwords do not match!';
                } elseif($_GET['error'] == 'username_exists') {
                    echo 'Username already exists!';
                } else {
                    echo 'Registration failed!';
                }
                ?>
            </p>
        <?php else: ?>
            <p class="error" style="display: none;">Error</p>
        <?php endif; ?>

        <form id="regfom" action="register.php" method="POST">
            <b>Personal Details</b>
            <input type="text" placeholder="First name..." id="fname" name="fname" 
                   value="<?php echo htmlspecialchars($_POST['fname'] ?? ''); ?>" required>
            <input type="text" placeholder="Last name..." id="lname" name="lname" 
                   value="<?php echo htmlspecialchars($_POST['lname'] ?? ''); ?>" required>

            <b>Date of birth</b>
            <input type="date" id="dob" name="dob" 
                   value="<?php echo htmlspecialchars($_POST['dob'] ?? ''); ?>" required><br>

            <b>Contact Info</b>
            <input type="text" placeholder="Phone Number..." id="phno" name="phno" 
                   value="<?php echo htmlspecialchars($_POST['phno'] ?? ''); ?>" required>
            <input type="email" placeholder="Email" id="email" name="email" 
                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>

            <b>Create User</b>
            <input type="text" placeholder="Username..." id="uname" name="uname" 
                   value="<?php echo htmlspecialchars($_POST['uname'] ?? ''); ?>" required>
            <input type="password" placeholder="Password..." id="passwd" name="passwd" required>
            <input type="password" placeholder="Retype Password..." id="repasswd" name="repasswd" required>

            <div class="butcon">
                <button class="button" onclick="window.location.href='loginpage.php'">Cancel</button>
                <button type="submit">Create</button>
            </div>
        </form>

        <!-- Add client-side password matching check -->
        <script>
            document.getElementById('regfom').addEventListener('submit', function(e) {
                const passwd = document.getElementById('passwd').value;
                const repasswd = document.getElementById('repasswd').value;
                
                if(passwd !== repasswd) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    return false;
                }
                return true;
            });
        </script>
    </body>
</html>