<?php
session_start();
include 'includes/db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid login</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- ✅ CORRECT CSS PLACEMENT -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="form-container" style="background-image: url('dash.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <form method="POST" class="form-box">

        <h2>Login</h2>

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <!-- LOGIN BUTTON -->
        <button type="submit" name="login">Login</button>
        <a href="forgot.php" class="btn-reset">Reset Password</a>


        <!-- CREATE ACCOUNT BUTTON -->
        <p style="margin-top:15px; text-align:center; color:white;">
            Don't have an account?
        </p>

        <a href="register.php" class="login-btn">Create Account</a>

        <!-- HOME BUTTON -->
        <a href="index.php" class="home-btn">Home</a>
        

    </form>

</div>

</body>
</html>