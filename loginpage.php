<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: uis.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Login page</title>
        <link rel="stylesheet" href="uis.css">
        <link rel="icon" type="image/x-icon" href="favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <h3>User Identification System (UIS)</h3>
        </header>
        <div style="padding: 5%;"> 
        <form class="login" action="login.php" method="POST">
            <label for="uname"><b>User Name</b></label><br>
            <input type="text" placeholder="Enter Username" id="uname" name="uname" required><br>
            <label for="passwd"><b>Password</b></label><br>
            <input type="password" placeholder="Enter Password" id="passwd" name="passwd" required><br>
            <input type="checkbox" onclick="showpw()"> Show Password
            <?php if(isset($_GET['error'])) { ?>
            <p id="error-msg" style="color: red; display: block;">Invalid username or password</p>
            <?php } else { ?>
            <p id="error-msg" style="display: none;">Invalid username or password</p>
            <?php } ?>

            <script>
                function showpw() {
                    var x = document.getElementById("passwd");
                    if (x.type === "password"){
                        x.type = "text";
                    }
                    else{
                        x.type = "password";
                    }
                }
            </script>
            <br><button class="loginb" type="submit">Log in</button>
            
            <p>Don't have an account?, <a href="signin.php">Sign-in</a></p>
        </form></div>
        <footer>
            <p style="text-align: center;">Connect with us for updates, support, and more!<br><a href="mailto:joeljoju.cy23@jecc.ac.in" title="click to send mail">Contact us</a></p>
        </footer>
    </body>
</html>